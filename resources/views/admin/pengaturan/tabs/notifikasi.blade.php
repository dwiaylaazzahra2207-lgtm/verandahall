@php $user = auth()->user(); @endphp

<div class="vh-set-card">
    <h2><i class="bi bi-bell text-primary"></i> Pengaturan Notifikasi</h2>
    <p class="text-muted small mb-4">Pilih jenis notifikasi yang ingin Anda terima.</p>

    <form action="{{ route('admin.pengaturan.update-notifikasi') }}" method="POST">
        @csrf

        <p class="fw-semibold small mb-2" style="color:#1e3a4c;">Notifikasi Email</p>
        <div class="d-flex flex-column gap-2 mb-4 ps-1">
            <input type="hidden" name="notify_email_booking" value="0">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="notify_email_booking" id="neb" value="1"
                       @checked(old('notify_email_booking', $user->notify_email_booking))>
                <label class="form-check-label" for="neb">
                    Booking Baru — notifikasi saat ada pemesanan masuk
                </label>
            </div>

            <input type="hidden" name="notify_email_review" value="0">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="notify_email_review" id="ner" value="1"
                       @checked(old('notify_email_review', $user->notify_email_review))>
                <label class="form-check-label" for="ner">
                    Review — notifikasi saat ada ulasan baru
                </label>
            </div>

            <input type="hidden" name="notify_email_payment" value="0">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="notify_email_payment" id="nep" value="1"
                       @checked(old('notify_email_payment', $user->notify_email_payment))>
                <label class="form-check-label" for="nep">
                    Pembayaran — notifikasi konfirmasi pembayaran
                </label>
            </div>
        </div>

        <p class="fw-semibold small mb-2" style="color:#1e3a4c;">Notifikasi Browser</p>
        <div class="ps-1 mb-4">
            <input type="hidden" name="notify_browser" value="0">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="notify_browser" id="nb" value="1"
                       @checked(old('notify_browser', $user->notify_browser))>
                <label class="form-check-label" for="nb">
                    Aktifkan notifikasi browser (push notification)
                </label>
            </div>
        </div>

        <button type="submit" class="btn vh-btn-soft px-4">
            <i class="bi bi-floppy2 me-1"></i> Simpan Pengaturan
        </button>
    </form>
</div>
