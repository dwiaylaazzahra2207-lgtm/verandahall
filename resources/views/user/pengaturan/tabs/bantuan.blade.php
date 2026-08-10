<div class="vh-set-card">
    <h2><i class="bi bi-question-circle text-primary"></i> Bantuan & Support</h2>
    <p class="text-muted mb-4">Butuh bantuan? Baca FAQ di bawah atau hubungi tim kami.</p>

    {{-- FAQ --}}
    <h6 class="fw-bold mb-3" style="font-size:.9rem;">Pertanyaan Umum (FAQ)</h6>
    <div class="accordion accordion-flush mb-4" id="faqUser">
        <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
            <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq1">
                    Bagaimana cara memesan gedung?
                </button>
            </h3>
            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqUser">
                <div class="accordion-body small text-muted">
                    Klik menu <strong>Pesan Gedung</strong> di sidebar, pilih gedung yang diinginkan, isi tanggal, waktu, dan detail acara, lalu klik <strong>Kirim Pemesanan</strong>. Pemesanan akan diproses oleh admin.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
            <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq2">
                    Berapa lama proses persetujuan pemesanan?
                </button>
            </h3>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqUser">
                <div class="accordion-body small text-muted">
                    Proses persetujuan biasanya memakan waktu 1–2 hari kerja. Anda akan mendapat notifikasi setelah admin memproses pemesanan Anda.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
            <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq3">
                    Apa yang dimaksud status "Menunggu"?
                </button>
            </h3>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqUser">
                <div class="accordion-body small text-muted">
                    Status <strong>Menunggu</strong> berarti pemesanan Anda sudah diterima dan sedang menunggu persetujuan dari admin. Harap bersabar.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
            <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq4">
                    Bagaimana jika tanggal yang saya pilih tidak tersedia?
                </button>
            </h3>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqUser">
                <div class="accordion-body small text-muted">
                    Sistem akan otomatis mendeteksi konflik jadwal. Jika tanggal sudah dipesan, Anda akan mendapat pesan "Tanggal tidak tersedia" dan diminta memilih tanggal lain.
                </div>
            </div>
        </div>

        <div class="accordion-item border rounded-3 overflow-hidden">
            <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq5">
                    Bagaimana cara mengubah data profil saya?
                </button>
            </h3>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqUser">
                <div class="accordion-body small text-muted">
                    Buka menu <strong>Pengaturan → Profil</strong>, ubah data yang diinginkan, lalu klik <strong>Simpan Perubahan</strong>.
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak Admin --}}
    <h6 class="fw-bold mb-3" style="font-size:.9rem;">Hubungi Kami</h6>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="border rounded-3 p-3 text-center">
                <div class="mb-2" style="font-size:1.5rem; color:#1e6fba;">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div class="fw-semibold small">Email</div>
                <div class="text-muted" style="font-size:.8rem;">support@verandahall.com</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-3 p-3 text-center">
                <div class="mb-2" style="font-size:1.5rem; color:#25d366;">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div class="fw-semibold small">WhatsApp</div>
                <div class="text-muted" style="font-size:.8rem;">+62 812-3456-7890</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-3 p-3 text-center">
                <div class="mb-2" style="font-size:1.5rem; color:#f59e0b;">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="fw-semibold small">Jam Operasional</div>
                <div class="text-muted" style="font-size:.8rem;">Senin–Sabtu, 08.00–17.00</div>
            </div>
        </div>
    </div>
</div>
