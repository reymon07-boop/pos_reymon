<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'auth'])
        ->name('login.process');

});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | USERS
            |--------------------------------------------------------------------------
            */

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


    /*
    |--------------------------------------------------------------------------
    | LAPORAN PENJUALAN ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->group(function () {

            Route::get('/laporan-penjualan', [
                PenjualanController::class,
                'laporan'
            ])->name('penjualan.laporan');

        });


    /*
    |--------------------------------------------------------------------------
    | ADMIN + KASIR
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,kasir')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PRODUK
        |--------------------------------------------------------------------------
        */

        Route::resource('/produk', ProdukController::class);


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN
        |--------------------------------------------------------------------------
        */

        Route::resource('/penjualan', PenjualanController::class);


        /*
        |--------------------------------------------------------------------------
        | ITEM PENJUALAN
        |--------------------------------------------------------------------------
        */

        Route::resource('/itempenjualan', ItemPenjualanController::class);


        /*
        |--------------------------------------------------------------------------
        | TENTANG TOKO
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/tentang-toko',
            'tentang-toko'
        )->name('tentang.toko');


        /*
        |--------------------------------------------------------------------------
        | TENTANG SAYA
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/tentang-saya',
            'tentang-saya'
        )->name('tentang.saya');

    });

});