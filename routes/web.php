<?php

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
Route::get('/', function () {
    return view('login');
})->name('login');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::resource('user', UserController::class);
    
    Route::resource('property', PropertyController::class);
});
