<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\AnggotaController as AdminAnggotaController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\DendaController as AdminDendaController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

// Anggota Controllers
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;
use App\Http\Controllers\Anggota\PeminjamanController as AnggotaPeminjamanController;
use App\Http\Controllers\Anggota\DendaController as AnggotaDendaController;
use App\Http\Controllers\Anggota\ProfileController as AnggotaProfileController;

// ==========================================================================
//  ROUTE PUBLIK (Guest)
// ==========================================================================

Route::middleware('guest.sikutu')->group(function () {
    // Halaman utama redirect ke login
    Route::get('/', fn() => redirect()->route('login'));

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Register (hanya siswa)
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

    // Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'requestReset'])->name('password.forgot.process');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.process');
});

// Logout (harus sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================================================
//  ROUTE ADMIN
// ==========================================================================

Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Buku
    Route::resource('buku', AdminBukuController::class)->parameters(['buku' => 'id']);

    // CRUD Genre
    Route::resource('genre', AdminGenreController::class)->parameters(['genre' => 'id'])->except(['show']);

    // CRUD Anggota
    Route::resource('anggota', AdminAnggotaController::class)->parameters(['anggota' => 'id']);
    Route::patch('/anggota/{id}/toggle-status', [AdminAnggotaController::class, 'toggleStatus'])->name('anggota.toggle-status');
    Route::post('/anggota/{id}/reset-password', [AdminAnggotaController::class, 'resetPassword'])->name('anggota.reset-password');

    // CRUD Peminjaman
    Route::resource('peminjaman', AdminPeminjamanController::class)->parameters(['peminjaman' => 'id']);

    // Pengembalian
    Route::get('/pengembalian', [AdminPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [AdminPengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian', [AdminPengembalianController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian/{id}', [AdminPengembalianController::class, 'show'])->name('pengembalian.show');
    Route::patch('/pengembalian/{id}/lunaskan', [AdminPengembalianController::class, 'lunaskanDenda'])->name('pengembalian.lunaskan');

    // Pengaturan Denda
    Route::get('/denda/setting', [AdminDendaController::class, 'index'])->name('denda.index');
    Route::put('/denda/setting', [AdminDendaController::class, 'update'])->name('denda.update');

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas/{id}', [LogAktivitasController::class, 'show'])->name('log-aktivitas.show');

    // Profile Admin
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'changePassword'])->name('profile.password');
});

// ==========================================================================
//  ROUTE SISWA (Anggota)
// ==========================================================================

Route::prefix('siswa')->name('siswa.')->middleware(['auth.anggota', 'cek.status'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])->name('dashboard');

    // Katalog Buku (read-only)
    Route::get('/katalog', [AnggotaBukuController::class, 'index'])->name('katalog.index');
    Route::get('/katalog/{id}', [AnggotaBukuController::class, 'show'])->name('katalog.show');

    // Histori Peminjaman (read-only)
    Route::get('/peminjaman', [AnggotaPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [AnggotaPeminjamanController::class, 'show'])->name('peminjaman.show');

    // Denda (read-only)
    Route::get('/denda', [AnggotaDendaController::class, 'index'])->name('denda.index');

    // Profile Siswa
    Route::get('/profile', [AnggotaProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AnggotaProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AnggotaProfileController::class, 'changePassword'])->name('profile.password');
});
