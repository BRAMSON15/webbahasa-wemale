<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kamus Bahasa Suku Wemale
|--------------------------------------------------------------------------
*/

// Beranda Utama (publik)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/beranda', [BerandaController::class, 'index']);
Route::get('/halamanutama', [BerandaController::class, 'index']);

// Pencarian kata (publik, AJAX JSON)
Route::get('/cari', [BerandaController::class, 'cari'])->name('cari');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login/pengunjung', [AuthController::class, 'showPengunjungLogin'])->name('login.pengunjung');
Route::get('/login-pengunjung', [AuthController::class, 'showPengunjungLogin']);
Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::get('/admin/login', [AuthController::class, 'showAdminLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/daftar', [AuthController::class, 'showRegister']);

// Area Pengunjung Terdaftar (terlindungi auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/pengunjung/beranda', [PengunjungController::class, 'index'])->name('pengunjung.beranda');
    Route::get('/beranda-pengunjung', [PengunjungController::class, 'index']);
    Route::post('/pengunjung/usulkan-kata', [PengunjungController::class, 'usulkanKata'])->name('pengunjung.usulkan-kata');

    // Fitur Kuis Bahasa Wemale untuk Pengunjung
    Route::get('/pengunjung/kuis', [PengunjungController::class, 'halamanKuis'])->name('pengunjung.kuis');
    Route::post('/pengunjung/kuis/submit', [PengunjungController::class, 'submitKuis'])->name('pengunjung.kuis.submit');
});

// Panel Admin (terlindungi)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Kamus (CRUD)
    Route::get('/kelola-kamus', [DashboardController::class, 'kelolaKamus'])->name('kelola-kamus');
    Route::post('/kelola-kamus', [DashboardController::class, 'storeKata'])->name('kelola-kamus.store');
    Route::put('/kelola-kamus/{kata}', [DashboardController::class, 'updateKata'])->name('kelola-kamus.update');
    Route::delete('/kelola-kamus/{kata}', [DashboardController::class, 'destroyKata'])->name('kelola-kamus.destroy');

    // Kelola Kategori (CRUD)
    Route::get('/kelola-kategori', [DashboardController::class, 'kelolaKategori'])->name('kelola-kategori');
    Route::post('/kelola-kategori', [DashboardController::class, 'storeKategori'])->name('kelola-kategori.store');
    Route::put('/kelola-kategori/{kategori}', [DashboardController::class, 'updateKategori'])->name('kelola-kategori.update');
    Route::delete('/kelola-kategori/{kategori}', [DashboardController::class, 'destroyKategori'])->name('kelola-kategori.destroy');

    // Kelola Kuis (CRUD)
    Route::get('/kelola-kuis', [DashboardController::class, 'kelolaKuis'])->name('kelola-kuis');
    Route::post('/kelola-kuis', [DashboardController::class, 'storeSoalKuis'])->name('kelola-kuis.store');
    Route::put('/kelola-kuis/{soalKuis}', [DashboardController::class, 'updateSoalKuis'])->name('kelola-kuis.update');
    Route::delete('/kelola-kuis/{soalKuis}', [DashboardController::class, 'destroySoalKuis'])->name('kelola-kuis.destroy');

    // Kelola Pengguna (CRUD)
    Route::get('/kelola-pengguna', [DashboardController::class, 'kelolaPengguna'])->name('kelola-pengguna');
    Route::post('/kelola-pengguna', [DashboardController::class, 'storeUser'])->name('kelola-pengguna.store');
    Route::put('/kelola-pengguna/{user}', [DashboardController::class, 'updateUser'])->name('kelola-pengguna.update');
    Route::delete('/kelola-pengguna/{user}', [DashboardController::class, 'destroyUser'])->name('kelola-pengguna.destroy');

    // Informasi Website
    Route::get('/informasi-website', [DashboardController::class, 'informasiWebsite'])->name('informasi-website');
    Route::post('/informasi-website', [DashboardController::class, 'updateInformasiWebsite'])->name('informasi-website.update');

    // Laporan
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');

    // Pengaturan
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');
    Route::put('/pengaturan/profil', [DashboardController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::put('/pengaturan/password', [DashboardController::class, 'updatePassword'])->name('pengaturan.password');
    Route::post('/pengaturan/sistem', [DashboardController::class, 'updateSistem'])->name('pengaturan.sistem');
});
