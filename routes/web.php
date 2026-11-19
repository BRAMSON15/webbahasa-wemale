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
});

// Panel Admin (terlindungi)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kelola-kamus', [DashboardController::class, 'kelolaKamus'])->name('kelola-kamus');
    Route::get('/kelola-kategori', [DashboardController::class, 'kelolaKategori'])->name('kelola-kategori');
    Route::get('/kelola-pengguna', [DashboardController::class, 'kelolaPengguna'])->name('kelola-pengguna');
    Route::get('/informasi-website', [DashboardController::class, 'informasiWebsite'])->name('informasi-website');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');
});
