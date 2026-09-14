@php
    $currentUser = Auth::user();
    $unreadCount = $currentUser ? $currentUser->notifikasi()->where('is_read', false)->count() : 0;
    $notifications = $currentUser ? $currentUser->notifikasi()->latest()->take(10)->get() : collect();
    $showWelcome = session()->pull('login_welcome', false);
@endphp

<div class="relative notif-dropdown-wrapper" id="notifDropdownWrapper">
    {{-- Bell Button --}}
    <button type="button"
            class="topbar-icon-btn relative flex items-center justify-center"
            id="notifDropdownToggle"
            aria-expanded="false"
            title="Notifikasi"
            onclick="toggleNotifDropdown(event)">
        <i class="bi bi-bell-fill text-base"></i>

        {{-- Badge angka merah kecil --}}
        <span id="notifBadgeCounter"
              class="notif-badge-counter {{ $unreadCount > 0 ? '' : 'd-none' }}"
              style="{{ $unreadCount > 0 ? '' : 'display: none !important;' }}">
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </span>
    </button>

    {{-- Animasi Message Box Selamat Datang dari Icon Lonceng --}}
    <div id="notifWelcomeBubble" class="notif-welcome-bubble" style="display: none;">
        <div class="d-flex align-items-start gap-2">
            <span class="wave-emoji flex-shrink-0" style="font-size: 1.4rem;">👋</span>
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="text-dark" style="font-size: .84rem;">Selamat Datang di VerandaHall!</strong>
                    <button type="button" class="btn-close-bubble" onclick="dismissWelcomeBubble(event)" title="Tutup">
                        &times;
                    </button>
                </div>
                <p class="mb-0 text-muted" style="font-size: .78rem; line-height: 1.35;">
                    Halo <strong>{{ $currentUser ? $currentUser->name : 'Pengguna' }}</strong>! Senang melihat Anda kembali. Silakan jelajahi & pesan gedung impian Anda.
                </p>
            </div>
        </div>
    </div>

    {{-- Dropdown Panel --}}
    <div class="notif-dropdown-menu shadow-lg" id="notifDropdownMenu" style="display: none;">
        {{-- Header --}}
        <div class="notif-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark" style="font-size: .9rem;">Notifikasi</span>
                <span id="notifHeaderCount"
                      class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"
                      style="font-size: .72rem; {{ $unreadCount > 0 ? '' : 'display: none;' }}">
                    {{ $unreadCount }} Baru
                </span>
            </div>
            <button type="button"
                    id="markAllReadBtn"
                    class="btn btn-link p-0 text-decoration-none text-muted"
                    style="font-size: .75rem; {{ $unreadCount > 0 ? '' : 'display: none;' }}"
                    onclick="markAllNotificationsAsRead(event)">
                Tandai semua dibaca
            </button>
        </div>

        {{-- List Notifikasi --}}
        <div class="notif-list-body" id="notifListBody">
            @forelse($notifications as $item)
                <div class="notif-item {{ !$item->is_read ? 'unread' : 'read' }}"
                     id="notif-item-{{ $item->id }}"
                     data-id="{{ $item->id }}"
                     data-read="{{ $item->is_read ? 'true' : 'false' }}"
                     onclick="handleNotificationClick({{ $item->id }}, this)">
                    <div class="d-flex gap-2 align-items-start position-relative">
                        <div class="notif-item-icon mt-1 flex-shrink-0">
                            @if(!$item->is_read)
                                <span class="notif-dot-indicator"></span>
                            @else
                                <span class="notif-dot-placeholder"></span>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-w-0 pe-4">
                            <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                                <h6 class="notif-title text-truncate {{ !$item->is_read ? 'fw-bold text-dark' : 'fw-semibold text-secondary' }}">
                                    {{ $item->title }}
                                </h6>
                                <span class="notif-time flex-shrink-0 text-muted" style="font-size: .7rem;">
                                    {{ $item->created_at?->diffForHumans() }}
                                </span>
                            </div>
                            <p class="notif-message mb-0 text-muted" style="font-size: .78rem; line-height: 1.35;">
                                {{ $item->message }}
                            </p>
                        </div>
                        {{-- Tombol Hapus (Icon Sampah) --}}
                        <button type="button"
                                class="btn-delete-notif"
                                title="Hapus notifikasi"
                                onclick="deleteNotification(event, {{ $item->id }}, this)">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="notif-empty-state text-center py-4 px-3 text-muted" id="notifEmptyState">
                    <i class="bi bi-bell-slash fs-3 d-block mb-2 text-secondary opacity-50"></i>
                    <p class="mb-0 small">Belum ada notifikasi.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer link ke halaman semua notifikasi --}}
        <div class="notif-footer border-top text-center py-2 bg-light rounded-bottom-4">
            <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('admin.notifikasi.index') : route('user.notifikasi.index') }}"
               class="text-decoration-none text-primary fw-semibold" style="font-size: .78rem;">
                Lihat Semua Notifikasi <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<style>
/* ── NOTIFIKASI DROPDOWN STYLING ───────────────────────────────────── */
.notif-dropdown-wrapper {
    position: relative;
    display: inline-block;
}

/* Badge merah kecil */
.notif-badge-counter {
    position: absolute;
    top: -3px;
    right: -4px;
    background-color: #ef4444;
    color: #ffffff;
    font-size: 0.68rem;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    line-height: 1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    z-index: 2;
    animation: notifPulse 2.5s infinite;
}

@keyframes notifPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Animasi lonceng berdering saat bubble pesan keluar */
@keyframes bellRing {
    0% { transform: rotate(0); }
    15% { transform: rotate(14deg); }
    30% { transform: rotate(-14deg); }
    45% { transform: rotate(10deg); }
    60% { transform: rotate(-10deg); }
    75% { transform: rotate(6deg); }
    100% { transform: rotate(0); }
}
.bell-ring-active {
    animation: bellRing 0.8s ease;
}

/* ── BUBBLE PESAN SELAMAT DATANG DARI ICON LONCENG ────────────────── */
.notif-welcome-bubble {
    position: absolute;
    top: calc(100% + 14px);
    right: -10px;
    width: 320px;
    max-width: calc(100vw - 32px);
    background: #ffffff;
    border-radius: 14px;
    padding: 13px 15px;
    box-shadow: 0 12px 32px rgba(15, 34, 53, 0.18), 0 4px 12px rgba(0,0,0,0.06);
    border: 1px solid rgba(30, 111, 186, 0.22);
    z-index: 1060;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transform-origin: top right;
    animation: bubblePopOut 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Panah segitiga menunjuk ke icon lonceng */
.notif-welcome-bubble::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 22px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #ffffff;
    filter: drop-shadow(0 -2px 1px rgba(0,0,0,0.06));
}

@keyframes bubblePopOut {
    0% {
        opacity: 0;
        transform: scale(0.5) translateY(-14px);
    }
    70% {
        transform: scale(1.03) translateY(2px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.wave-emoji {
    display: inline-block;
    animation: waveHand 1.6s ease-in-out infinite;
    transform-origin: 70% 70%;
}

@keyframes waveHand {
    0%, 100% { transform: rotate(0deg); }
    20% { transform: rotate(16deg); }
    40% { transform: rotate(-14deg); }
    60% { transform: rotate(12deg); }
    80% { transform: rotate(-8deg); }
}

.btn-close-bubble {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 1.15rem;
    line-height: 1;
    padding: 0 2px;
    cursor: pointer;
    transition: color 0.15s ease;
}
.btn-close-bubble:hover {
    color: #ef4444;
}

/* Menu panel dropdown */
.notif-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 350px;
    max-width: calc(100vw - 32px);
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid rgba(15, 34, 53, 0.08);
    box-shadow: 0 10px 25px -5px rgba(15, 34, 53, 0.15), 0 8px 10px -6px rgba(15, 34, 53, 0.1);
    z-index: 1050;
    overflow: hidden;
    font-family: 'Plus Jakarta Sans', sans-serif;
    animation: notifFadeIn 0.2s ease-out;
}

@keyframes notifFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.notif-list-body {
    max-height: 380px;
    overflow-y: auto;
}

/* Scrollbar halus */
.notif-list-body::-webkit-scrollbar {
    width: 5px;
}
.notif-list-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

/* Item notifikasi */
.notif-item {
    padding: 11px 14px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background-color 0.15s ease;
    text-align: left;
    position: relative;
}
.notif-item:last-child {
    border-bottom: none;
}
.notif-item:hover {
    background-color: #f8fafc !important;
}

/* Tanda visual notifikasi belum dibaca */
.notif-item.unread {
    background-color: #f0f7ff;
    border-left: 3px solid #1e6fba;
}
.notif-item.read {
    background-color: #ffffff;
    border-left: 3px solid transparent;
}

.notif-title {
    font-size: .83rem;
    margin: 0;
}

/* Titik biru indikator */
.notif-dot-indicator {
    width: 8px;
    height: 8px;
    background-color: #1e6fba;
    border-radius: 50%;
    display: inline-block;
}
.notif-dot-placeholder {
    width: 8px;
    height: 8px;
    display: inline-block;
    opacity: 0;
}

/* Tombol hapus (icon sampah) */
.btn-delete-notif {
    position: absolute;
    top: 2px;
    right: 0;
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: transparent;
    border: none;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.2s ease;
    padding: 0;
    opacity: 0.45;
}
.notif-item:hover .btn-delete-notif {
    opacity: 1;
}
.btn-delete-notif:hover {
    background: #fee2e2;
    color: #ef4444;
    transform: scale(1.15);
}
</style>

<script>
(function () {
    // Variabel state lokal
    let unreadCount = {{ (int) $unreadCount }};

    // Tampilkan animasi bubble selamat datang saat baru login atau berganti akun
    const shouldShowWelcome = {{ $showWelcome ? 'true' : 'false' }};
    const currentUserId = '{{ Auth::id() }}';
    const lastWelcomedUser = sessionStorage.getItem('vh_last_welcomed_user');

    if (shouldShowWelcome || (currentUserId && lastWelcomedUser !== currentUserId)) {
        setTimeout(function () {
            showWelcomeBubble();
            sessionStorage.setItem('vh_last_welcomed_user', currentUserId);
        }, 400);
    }

    window.showWelcomeBubble = function () {
        const bubble = document.getElementById('notifWelcomeBubble');
        const bellBtn = document.getElementById('notifDropdownToggle');
        if (!bubble) return;

        bubble.style.display = 'block';
        if (bellBtn) bellBtn.classList.add('bell-ring-active');

        setTimeout(() => {
            if (bellBtn) bellBtn.classList.remove('bell-ring-active');
        }, 850);

        // Otomatis fade out setelah 6.5 detik
        setTimeout(() => {
            dismissWelcomeBubble();
        }, 6500);
    };

    window.dismissWelcomeBubble = function (event) {
        if (event) event.stopPropagation();
        const bubble = document.getElementById('notifWelcomeBubble');
        if (!bubble || bubble.style.display === 'none') return;

        bubble.style.transition = 'all 0.3s ease';
        bubble.style.opacity = '0';
        bubble.style.transform = 'scale(0.8) translateY(-10px)';

        setTimeout(() => {
            bubble.style.display = 'none';
        }, 300);
    };

    window.toggleNotifDropdown = function (event) {
        event.stopPropagation();
        dismissWelcomeBubble(); // Tutup bubble jika lonceng diklik

        const menu = document.getElementById('notifDropdownMenu');
        const btn = document.getElementById('notifDropdownToggle');
        if (!menu) return;

        const isVisible = menu.style.display !== 'none';
        menu.style.display = isVisible ? 'none' : 'block';
        if (btn) btn.setAttribute('aria-expanded', !isVisible);
    };

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (event) {
        const wrapper = document.getElementById('notifDropdownWrapper');
        const menu = document.getElementById('notifDropdownMenu');
        if (wrapper && menu && !wrapper.contains(event.target)) {
            menu.style.display = 'none';
            const btn = document.getElementById('notifDropdownToggle');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
    });

    // Handle klik notifikasi: otomatis tandai sudah dibaca
    window.handleNotificationClick = function (notifId, element) {
        if (!element) return;
        const isRead = element.getAttribute('data-read') === 'true';

        // Jika belum dibaca, langsung ubah visual & kirim request
        if (!isRead) {
            element.setAttribute('data-read', 'true');
            element.classList.remove('unread');
            element.classList.add('read');

            const title = element.querySelector('.notif-title');
            if (title) {
                title.classList.remove('fw-bold', 'text-dark');
                title.classList.add('fw-semibold', 'text-secondary');
            }

            const dot = element.querySelector('.notif-dot-indicator');
            if (dot) {
                dot.classList.remove('notif-dot-indicator');
                dot.classList.add('notif-dot-placeholder');
            }

            // Kurangi counter
            if (unreadCount > 0) {
                unreadCount--;
                updateBadgeCounter(unreadCount);
            }

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
                    unreadCount = data.unread_count;
                    updateBadgeCounter(unreadCount);
                }
            })
            .catch(err => {
                console.error('Gagal memperbarui status notifikasi:', err);
            });
        }
    };

    // Handle hapus notifikasi (Icon Sampah)
    window.deleteNotification = function (event, notifId, btnElement) {
        event.stopPropagation(); // Cegah pemicu handleNotificationClick

        const item = document.getElementById('notif-item-' + notifId);
        if (!item) return;

        const isUnread = item.getAttribute('data-read') === 'false';

        // Animasi keluar
        item.style.transition = 'all 0.25s ease';
        item.style.opacity = '0';
        item.style.transform = 'translateX(25px)';

        setTimeout(function () {
            item.remove();
            // Cek sisa notifikasi
            const remaining = document.querySelectorAll('.notif-item');
            if (remaining.length === 0) {
                const listBody = document.getElementById('notifListBody');
                if (listBody) {
                    listBody.innerHTML = `
                        <div class="notif-empty-state text-center py-4 px-3 text-muted" id="notifEmptyState">
                            <i class="bi bi-bell-slash fs-3 d-block mb-2 text-secondary opacity-50"></i>
                            <p class="mb-0 small">Belum ada notifikasi.</p>
                        </div>
                    `;
                }
            }
        }, 250);

        if (isUnread && unreadCount > 0) {
            unreadCount--;
            updateBadgeCounter(unreadCount);
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
                unreadCount = data.unread_count;
                updateBadgeCounter(unreadCount);
            }
        })
        .catch(err => {
            console.error('Gagal menghapus notifikasi:', err);
        });
    };

    // Tandai semua dibaca
    window.markAllNotificationsAsRead = function (event) {
        event.stopPropagation();
        if (unreadCount <= 0) return;

        // Ubah semua item visual jadi read
        document.querySelectorAll('.notif-item.unread').forEach(function (el) {
            el.setAttribute('data-read', 'true');
            el.classList.remove('unread');
            el.classList.add('read');

            const title = el.querySelector('.notif-title');
            if (title) {
                title.classList.remove('fw-bold', 'text-dark');
                title.classList.add('fw-semibold', 'text-secondary');
            }

            const dot = el.querySelector('.notif-dot-indicator');
            if (dot) {
                dot.classList.remove('notif-dot-indicator');
                dot.classList.add('notif-dot-placeholder');
            }
        });

        unreadCount = 0;
        updateBadgeCounter(0);

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
                unreadCount = data.unread_count;
                updateBadgeCounter(unreadCount);
            }
        })
        .catch(err => console.error('Gagal menandai semua dibaca:', err));
    };

    function updateBadgeCounter(count) {
        const badge = document.getElementById('notifBadgeCounter');
        const headerCount = document.getElementById('notifHeaderCount');
        const markAllBtn = document.getElementById('markAllReadBtn');

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

        if (markAllBtn) {
            markAllBtn.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }
})();
</script>
