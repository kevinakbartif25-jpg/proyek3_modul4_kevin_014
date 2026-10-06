<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

// Publik: lihat daftar barang tanpa login
Route::get('/', fn () => redirect()->route('index'));
Route::get('/index', [BarangController::class, 'index'])->name('index');

// Hanya tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Wajib login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');
    Route::post('/keranjang/{barang}/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/{barang}/ubah', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');
    Route::post('/keranjang/{barang}/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::post('/checkout', [PesananController::class, 'checkout'])->name('checkout');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
});
