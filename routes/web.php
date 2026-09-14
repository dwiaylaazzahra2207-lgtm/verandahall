<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Admin\RiwayatPemesananController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserBerandaController;
use App\Http\Controllers\User\UserPemesananController;
use App\Http\Controllers\User\UserPengaturanController;
use App\Http\Controllers\User\UserRiwayatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');


// ================== DASHBOARD (legacy / default after verification, etc.) ==================
Route::get('/dashboard', function () {
    return redirect()->route(
        Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard'
    );
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== USER ==================
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'verified', 'role:user'])
    ->group(function () {
        // Beranda
        Route::get('/beranda', [UserBerandaController::class, 'index'])->name('beranda');
        Route::get('/gedung/{gedung}', [UserBerandaController::class, 'show'])->name('gedung.show');

        // Redirect /dashboard → beranda
        Route::get('/dashboard', fn () => redirect()->route('user.beranda'))->name('dashboard');

        // Pemesanan
        Route::get('/pemesanan', [UserPemesananController::class, 'index'])->name('pemesanan.index');
        Route::get('/pemesanan/buat', [UserPemesananController::class, 'create'])->name('pemesanan.create');
        Route::post('/pemesanan', [UserPemesananController::class, 'store'])->name('pemesanan.store');
        Route::post('/pemesanan/cek-ketersediaan', [UserPemesananController::class, 'checkAvailability'])->name('pemesanan.check');

        // Riwayat
        Route::get('/riwayat', [UserRiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{booking}', [UserRiwayatController::class, 'show'])->name('riwayat.show');

        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

        // Pengaturan
        Route::get('/pengaturan', fn () => redirect()->route('user.pengaturan.index', ['tab' => 'profil']));
        Route::get('/pengaturan/{tab}', [UserPengaturanController::class, 'index'])
            ->where('tab', 'profil|keamanan|notifikasi|bantuan')
            ->name('pengaturan.index');
        Route::post('/pengaturan/profil', [UserPengaturanController::class, 'updateProfil'])->name('pengaturan.update-profil');
        Route::post('/pengaturan/keamanan', [UserPengaturanController::class, 'updateKeamanan'])->name('pengaturan.update-keamanan');
        Route::post('/pengaturan/notifikasi', [UserPengaturanController::class, 'updateNotifikasi'])->name('pengaturan.update-notifikasi');
    });

// ================== ADMIN ==================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {

        Route::get('/', fn () => redirect()->route('admin.dashboard'));

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::redirect('/manajemen-pemesanan', '/admin/pemesanan')->name('manajemenpemesanan');

        Route::get('/notifikasi', [AdminNotifikasiController::class, 'index'])->name('notifikasi.index');

        Route::resource('users', UserManagementController::class)->except(['show']);

        Route::resource('gedung', GedungController::class);

        Route::get('/pemesanan', [BookingController::class, 'index'])->name('pemesanan.index');
        Route::get('/pemesanan/{booking}', [BookingController::class, 'show'])->name('pemesanan.show');
        Route::post('/pemesanan/{booking}/approve', [BookingController::class, 'approve'])->name('pemesanan.approve');
        Route::post('/pemesanan/{booking}/reject', [BookingController::class, 'reject'])->name('pemesanan.reject');

        Route::get('/riwayat', [RiwayatPemesananController::class, 'index'])->name('riwayat.index');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        Route::get('/pengaturan', fn () => redirect()->route('admin.pengaturan.index', ['tab' => 'profil']));
        Route::get('/pengaturan/{tab}', [PengaturanController::class, 'index'])
            ->where('tab', 'profil|venue|jadwal|notifikasi|keamanan|bantuan')
            ->name('pengaturan.index');
        Route::post('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.update-profil');
        Route::post('/pengaturan/venue', [PengaturanController::class, 'updateVenue'])->name('pengaturan.update-venue');
        Route::post('/pengaturan/jadwal', [PengaturanController::class, 'updateJadwal'])->name('pengaturan.update-jadwal');
        Route::post('/pengaturan/notifikasi', [PengaturanController::class, 'updateNotifikasi'])->name('pengaturan.update-notifikasi');
        Route::post('/pengaturan/keamanan', [PengaturanController::class, 'updateKeamanan'])->name('pengaturan.update-keamanan');
    });


// ================== NOTIFIKASI & PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/notifikasi', function () {
        return redirect()->route(
            Auth::user()->role === 'admin' ? 'admin.notifikasi.index' : 'user.notifikasi.index'
        );
    })->name('notifikasi.all');

    Route::post('/notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.mark-as-read');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
    Route::delete('/notifikasi/{notifikasi}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';