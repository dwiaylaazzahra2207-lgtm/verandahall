@extends('layouts.user')

@section('title', 'Semua Notifikasi')
@section('page-title', 'Notifikasi')

@push('styles')
<style>
    /* ── NOTIFIKASI PAGE STYLING ── */
    .notif-page-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(15, 34, 53, 0.06);
        border: 1px solid rgba(15, 34, 53, 0.06);
        overflow: hidden;
    }

    .notif-page-item {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        text-align: left;
    }
    .notif-page-item:last-child {
        border-bottom: none;
    }
    .notif-page-item:hover {
        background-color: #f8fafc !important;
    }

    /* Pembeda visual unread */
    .notif-page-item.unread {
        background-color: #f0f7ff;
        border-left: 4px solid #1e6fba;
    }
    .notif-page-item.read {
        background-color: #ffffff;
        border-left: 4px solid transparent;
    }

    .notif-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background-color: #1e6fba;
        display: inline-block;
        flex-shrink: 0;
    }
    .notif-dot-placeholder {
        width: 9px;
        height: 9px;
        display: inline-block;
        flex-shrink: 0;
        opacity: 0;
    }

    /* Tombol hapus */
    .btn-trash-notif {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: transparent;
        border: none;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-trash-notif:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')

@php
    $referrer = url()->previous();
    $backUrl = ($referrer && $referrer !== url()->current()) ? $referrer : route('user.beranda');
@endphp

{{-- Header bar & Tombol Kembali --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ $backUrl }}" class="btn btn-light rounded-pill btn-sm px-3 shadow-sm text-secondary fw-semibold border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <h5 class="fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">Semua Notifikasi</h5>
            <p class="text-muted small mb-0">Kelola dan tinjau seluruh riwayat notifikasi akun Anda</p>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="button"
                id="pageMarkAllBtn"
                class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold {{ $unreadCount > 0 ? '' : 'd-none' }}"
                onclick="markAllPageNotificationsAsRead(event)">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </div>
</div>

{{-- Container List Notifikasi --}}
<div class="notif-page-card">
    <div id="pageNotifList">
        @forelse($notifikasi as $n)
            <div class="notif-page-item {{ !$n->is_read ? 'unread' : 'read' }}"
                 id="page-notif-item-{{ $n->id }}"
                 data-id="{{ $n->id }}"
                 data-read="{{ $n->is_read ? 'true' : 'false' }}"
                 onclick="handlePageNotificationClick({{ $n->id }}, this)">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div class="d-flex align-items-start gap-3 flex-grow-1 min-w-0">
                        {{-- Dot Indikator --}}
                        <div class="mt-2">
                            @if(!$n->is_read)
                                <span class="notif-dot"></span>
                            @else
                                <span class="notif-dot-placeholder"></span>
                            @endif
                        </div>

                        {{-- Konten Notifikasi --}}
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <h6 class="mb-0 notif-title {{ !$n->is_read ? 'fw-bold text-dark' : 'fw-semibold text-secondary' }}" style="font-size: .95rem;">
                                    {{ $n->title }}
                                </h6>
                                @if(!$n->is_read)
                                    <span class="badge bg-danger rounded-pill px-2 py-1 notif-status-badge" style="font-size:.7rem;">
                                        Baru
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 notif-status-badge" style="font-size:.7rem;">
                                        Sudah Dibaca
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted mb-1" style="font-size: .85rem; line-height: 1.45;">
                                {{ $n->message }}
                            </p>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: .75rem;">
                                <i class="bi bi-clock"></i>
                                <span>{{ $n->created_at->diffForHumans() }}</span>
                                <span>&bull;</span>
                                <span>{{ $n->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi Hapus --}}
                    <div class="flex-shrink-0">
                        <button type="button"
                                class="btn-trash-notif"
                                title="Hapus Notifikasi"
                                onclick="deletePageNotification(event, {{ $n->id }}, this)">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-5 text-center text-muted" id="pageEmptyState">
                <i class="bi bi-bell-slash fs-1 d-block mb-3 text-secondary opacity-50"></i>
                <h6 class="fw-semibold">Belum Ada Notifikasi</h6>
                <p class="small text-muted mb-0">Anda tidak memiliki pemberitahuan saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination jika ada --}}
    @if($notifikasi instanceof \Illuminate\Pagination\LengthAwarePaginator && $notifikasi->hasPages())
        <div class="p-3 border-top d-flex justify-content-center bg-light">
            {{ $notifikasi->links() }}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Klik notifikasi: tandai sudah dibaca via AJAX
    function handlePageNotificationClick(notifId, element) {
        if (!element) return;
        const isRead = element.getAttribute('data-read') === 'true';

        if (!isRead) {
            // Ubah visual seketika
            element.setAttribute('data-read', 'true');
            element.classList.remove('unread');
            element.classList.add('read');

            const title = element.querySelector('.notif-title');
            if (title) {
                title.classList.remove('fw-bold', 'text-dark');
                title.classList.add('fw-semibold', 'text-secondary');
            }

            const dot = element.querySelector('.notif-dot');
            if (dot) {
                dot.classList.remove('notif-dot');
                dot.classList.add('notif-dot-placeholder');
            }

            const badge = element.querySelector('.notif-status-badge');
            if (badge) {
                badge.className = 'badge bg-light text-secondary border rounded-pill px-2 py-1 notif-status-badge';
                badge.innerText = 'Sudah Dibaca';
            }

            // Sync dengan navbar bell counter
            syncNavbarBadgeDecrement();

            // Request ke backend
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            fetch('{{ url("/notifikasi") }}/' + notifId + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data && typeof data.unread_count !== 'undefined') {
                    updateNavbarBadge(data.unread_count);
                }
            })
            .catch(err => console.error('Gagal memperbarui notifikasi:', err));
        }
    }

    // Hapus notifikasi di halaman
    function deletePageNotification(event, notifId, btn) {
        event.stopPropagation();

        const item = document.getElementById('page-notif-item-' + notifId);
        if (!item) return;

        const isUnread = item.getAttribute('data-read') === 'false';

        // Animasi keluar
        item.style.transition = 'all 0.25s ease';
        item.style.opacity = '0';
        item.style.transform = 'translateX(30px)';

        setTimeout(() => {
            item.remove();
            const remaining = document.querySelectorAll('.notif-page-item');
            if (remaining.length === 0) {
                const list = document.getElementById('pageNotifList');
                if (list) {
                    list.innerHTML = `
                        <div class="p-5 text-center text-muted" id="pageEmptyState">
                            <i class="bi bi-bell-slash fs-1 d-block mb-3 text-secondary opacity-50"></i>
                            <h6 class="fw-semibold">Belum Ada Notifikasi</h6>
                            <p class="small text-muted mb-0">Anda tidak memiliki pemberitahuan saat ini.</p>
                        </div>
                    `;
                }
            }
        }, 250);

        if (isUnread) {
            syncNavbarBadgeDecrement();
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        fetch('{{ url("/notifikasi") }}/' + notifId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data && typeof data.unread_count !== 'undefined') {
                updateNavbarBadge(data.unread_count);
            }
        })
        .catch(err => console.error('Gagal menghapus notifikasi:', err));
    }

    // Tandai semua dibaca di halaman
    function markAllPageNotificationsAsRead(event) {
        event.stopPropagation();

        document.querySelectorAll('.notif-page-item.unread').forEach(el => {
            el.setAttribute('data-read', 'true');
            el.classList.remove('unread');
            el.classList.add('read');

            const title = el.querySelector('.notif-title');
            if (title) {
                title.classList.remove('fw-bold', 'text-dark');
                title.classList.add('fw-semibold', 'text-secondary');
            }

            const dot = el.querySelector('.notif-dot');
            if (dot) {
                dot.classList.remove('notif-dot');
                dot.classList.add('notif-dot-placeholder');
            }

            const badge = el.querySelector('.notif-status-badge');
            if (badge) {
                badge.className = 'badge bg-light text-secondary border rounded-pill px-2 py-1 notif-status-badge';
                badge.innerText = 'Sudah Dibaca';
            }
        });

        const btn = document.getElementById('pageMarkAllBtn');
        if (btn) btn.classList.add('d-none');

        updateNavbarBadge(0);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        fetch('{{ route("notifikasi.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data && typeof data.unread_count !== 'undefined') {
                updateNavbarBadge(data.unread_count);
            }
        })
        .catch(err => console.error('Gagal menandai semua dibaca:', err));
    }

    // Helper sinkronisasi badge lonceng navbar
    function syncNavbarBadgeDecrement() {
        const badge = document.getElementById('notifBadgeCounter');
        if (badge && !badge.classList.contains('d-none')) {
            let count = parseInt(badge.innerText, 10);
            if (!isNaN(count) && count > 0) {
                updateNavbarBadge(count - 1);
            }
        }
    }

    function updateNavbarBadge(count) {
        const badge = document.getElementById('notifBadgeCounter');
        const headerCount = document.getElementById('notifHeaderCount');
        const markAllBtn = document.getElementById('markAllReadBtn');
        const pageBtn = document.getElementById('pageMarkAllBtn');

        if (badge) {
            if (count > 0) {
                badge.innerText = count > 99 ? '99+' : count;
                badge.classList.remove('d-none');
                badge.style.display = 'inline-flex';
            } else {
                badge.classList.add('d-none');
                badge.style.display = 'none';
            }
        }

        if (headerCount) {
            if (count > 0) {
                headerCount.innerText = count + ' Baru';
                headerCount.style.display = 'inline-block';
            } else {
                headerCount.style.display = 'none';
            }
        }

        if (markAllBtn) markAllBtn.style.display = count > 0 ? 'inline-block' : 'none';
        if (pageBtn) {
            if (count > 0) pageBtn.classList.remove('d-none');
            else pageBtn.classList.add('d-none');
        }
    }
</script>
@endpush
