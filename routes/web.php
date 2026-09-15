<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

// Redirect root URL langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang bisa diakses ketika user BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'auth'])->name('login.process');
});

// Route yang hanya bisa diakses ketika user SUDAH login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // =========================
    // KHUSUS ADMIN
    // =========================
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/users', [UserController::class, 'index'])
                ->name('users');

            Route::get('/users/create', [UserController::class, 'create'])
                ->name('users.create');

            Route::post('/users/store', [UserController::class, 'store'])
                ->name('users.store');

            Route::get('/users/edit/{user}', [UserController::class, 'edit'])
                ->name('users.edit');

            Route::post('/users/update/{user}', [UserController::class, 'update'])
                ->name('users.update');

            Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])
                ->name('users.destroy');
        });

    // =========================
    // ADMIN & KASIR
    // =========================
    Route::middleware('role:admin,kasir')->group(function () {

        // Produk
        Route::resource('/produk', ProdukController::class);

        // Penjualan
        Route::resource('/penjualan', PenjualanController::class);

        // Item Penjualan
        Route::resource('/itempenjualan', ItemPenjualanController::class);

        // Tentang Toko
        Route::view('/tentang-toko', 'tentang-toko')->name('tentang.toko');

        // Tentang Saya
        Route::view('/tentang-saya', 'tentang-saya')->name('tentang.saya');
    });
});