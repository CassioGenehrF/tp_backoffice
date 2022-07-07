<?php

use App\Http\Controllers\BrokerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('/auth', [LoginController::class, 'auth'])->name('auth.user');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout.user');

    Route::middleware(['owner'])->group(function () {
        Route::get('/owner', [OwnerController::class, 'index'])->name('owner.page');
        Route::get('/owner/unblock', [OwnerController::class, 'unblockPage'])->name('owner.unblock_page');

        Route::post('/block', [OwnerController::class, 'block'])->name('owner.block');
        Route::post('/unblock', [OwnerController::class, 'unblock'])->name('owner.unblock');
    });

    Route::middleware(['broker'])->group(function () {
        Route::get('/broker', [BrokerController::class, 'index'])->name('broker.page');
    });

    Route::resource('user', UserController::class);

    Route::resource('property', PropertyController::class);
});
