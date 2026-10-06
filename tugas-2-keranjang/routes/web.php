<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('index'));
Route::get('/index', [BarangController::class, 'index'])->name('index');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
Route::post('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');
Route::post('/keranjang/{barang}/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/{barang}/ubah', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');
Route::post('/keranjang/{barang}/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');