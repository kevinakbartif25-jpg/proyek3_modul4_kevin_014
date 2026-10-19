<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])
    ->middleware(['auth', 'can:manage-roles'])
    ->name('admin.users.role.update');
    
Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Route simulasi keranjang (Modul 5 poin 4.9 & AC-06)
    Route::post('/cart/add', function () {
        return response()->json(['message' => 'Berhasil tambah cart']);
    })->middleware('can:use-cart')->name('cart.add');
});