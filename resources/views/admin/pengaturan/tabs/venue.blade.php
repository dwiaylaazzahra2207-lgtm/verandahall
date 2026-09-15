<div class="row g-4">
    <div class="col-lg-7">
        <div class="vh-set-card h-100">
            <h2><i class="bi bi-building text-primary"></i> Manajemen Venue</h2>

            {{-- Error validation --}}
            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pengaturan.update-venue') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="d-flex flex-column gap-3">
                    <div class="vh-set-input">
                        <label class="vh-set-label">Nama Venue</label>
                        <input type="text" name="nama_venue"
                               class="form-control @error('nama_venue') is-invalid @enderror"
                               value="{{ old('nama_venue', $venue->nama_venue) }}"
                               placeholder="Contoh: VerandaHall Sidoarjo">
                        @error('nama_venue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="vh-set-input">
                        <label class="vh-set-label">Jenis Lapangan / Gedung</label>
                        <input type="text" name="jenis_lapangan"
                               class="form-control @error('jenis_lapangan') is-invalid @enderror"
                               value="{{ old('jenis_lapangan', $venue->jenis_lapangan) }}"
                               placeholder="Contoh: Gedung Serbaguna, Aula">
                        @error('jenis_lapangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="vh-set-input">
                        <label class="vh-set-label">Lokasi / Alamat</label>
                        <input type="text" name="lokasi"
                               class="form-control @error('lokasi') is-invalid @enderror"
                               value="{{ old('lokasi', $venue->lokasi) }}"
                               placeholder="Contoh: Jl. Raya Sidoarjo No. 1">
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="vh-set-input">
                        <label class="vh-set-label">Fasilitas</label>
                        <textarea name="fasilitas" rows="3"
                                  class="form-control @error('fasilitas') is-invalid @enderror"
                                  placeholder="Contoh: AC, Sound System, Proyektor, Parkir Luas">{{ old('fasilitas', $venue->fasilitas) }}</textarea>
                        @error('fasilitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="vh-set-input">
                        <label class="vh-set-label">Link Google Maps</label>
                        <input type="text" name="link_maps"
                               class="form-control @error('link_maps') is-invalid @enderror"
                               value="{{ old('link_maps', $venue->link_maps) }}"
                               placeholder="https://maps.google.com/...">
                        @error('link_maps')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="vh-set-input">
                        <label class="vh-set-label">Foto Venue</label>
                        <input type="file" name="foto" accept="image/*"
                               class="form-control @error('foto') is-invalid @enderror">
                        <div class="form-text">PNG, JPG maks. 4 MB. Kosongkan jika tidak ingin mengganti.</div>
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn vh-btn-teal text-white px-4">
                        <i class="bi bi-floppy2 me-1"></i> Simpan Venue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="vh-set-card h-100">
            <h6 class="fw-bold mb-3">Preview Foto Venue</h6>
            <div class="vh-upload-zone mb-3">
                @if($venue->foto)
                    <img src="{{ asset('storage/'.$venue->foto) }}"
                         alt="Foto Venue"
                         class="rounded-3 w-100"
                         style="max-height:220px; object-fit:cover;">
                @else
                    <i class="bi bi-camera fs-1 mb-2 text-muted"></i>
                    <span class="small text-muted">Belum ada foto</span>
                @endif
            </div>

            @if($venue->nama_venue || $venue->lokasi)
                <div class="small mt-2">
                    @if($venue->nama_venue)
                        <div class="fw-semibold">{{ $venue->nama_venue }}</div>
                    @endif
                    @if($venue->lokasi)
                        <div class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $venue->lokasi }}</div>
                    @endif
                    @if($venue->link_maps)
                        <a href="{{ $venue->link_maps }}" target="_blank" class="small text-primary mt-1 d-inline-block">
                            <i class="bi bi-map me-1"></i>Buka Maps
                        </a>
                    @endif
                </div>
            @else
                <p class="small text-muted mb-0">Isi form di sebelah kiri untuk menyimpan informasi venue.</p>
            @endif

            @if($venue->foto || $venue->nama_venue || $venue->lokasi || $venue->jenis_lapangan || $venue->fasilitas || $venue->link_maps)
                <hr class="my-3 text-muted opacity-25">
                <div class="d-flex flex-column gap-2">
                    @if($venue->foto)
                        <form action="{{ route('admin.pengaturan.delete-venue-foto') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto venue ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-image me-1"></i> Hapus Foto Venue
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.pengaturan.delete-venue') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data venue ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-trash3 me-1"></i> Hapus Data Venue
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
