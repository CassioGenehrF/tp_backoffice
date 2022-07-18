<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('auth', [LoginController::class, 'auth'])->name('auth.user');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout.user');

    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
        Route::get('', [AdminController::class, 'index'])->name('admin.page');
        Route::get('unblock', [AdminController::class, 'unblockPage'])->name('admin.unblock_page');
        Route::get('report', [AdminController::class, 'report'])->name('admin.report');
        Route::get('reservation', [AdminController::class, 'reservation'])->name('admin.reservation');
        Route::get('reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
        Route::get('reservations/{id}', [AdminController::class, 'reservationDetails'])->name('admin.reservations_details');
        Route::get('reservations/{id}/contract', [AdminController::class, 'downloadContract'])->name('admin.download_contract');
        Route::get('property/{id}/contract', [AdminController::class, 'downloadContractProperty'])->name('admin.download_contract_property');
        Route::get('report', [AdminController::class, 'report'])->name('admin.report');
        Route::get('report/indication', [AdminController::class, 'reportIndication'])->name('admin.report_indication');
        Route::get('report/regional', [AdminController::class, 'reportRegional'])->name('admin.report_regional');
        Route::get('properties', [AdminController::class, 'properties'])->name('admin.properties');
        
        Route::get('getProperty/{propertyId}', [AdminController::class, 'getProperty'])->name('admin.property');
        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [AdminController::class, 'getCalendarAsJson']);
        Route::get('getReport/{propertyId}', [AdminController::class, 'getReport']);
        
        Route::post('block', [AdminController::class, 'block'])->name('admin.block');
        Route::post('unblock', [AdminController::class, 'unblock'])->name('admin.unblock');
        Route::post('rent', [AdminController::class, 'rent'])->name('admin.rent');
        Route::post('property', [AdminController::class, 'propertyInfo'])->name('admin.property_info');
        Route::delete('reservation/destroy', [AdminController::class, 'reservationDestroy'])->name('admin.reservation_destroy');
        Route::put('reservation/edit', [AdminController::class, 'reservationEdit'])->name('admin.reservation_edit');
    });

    Route::group(['prefix' => 'broker', 'middleware' => ['broker']], function () {
        Route::get('', [BrokerController::class, 'index'])->name('broker.page');
        Route::get('reservations', [BrokerController::class, 'reservations'])->name('broker.reservations');
        Route::get('reservations/{id}', [BrokerController::class, 'reservationDetails'])->name('broker.reservations_details');
        Route::get('reservations/{id}/contract', [BrokerController::class, 'downloadContract'])->name('broker.download_contract');
        Route::get('report', [BrokerController::class, 'report'])->name('broker.report');

        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [BrokerController::class, 'getCalendarAsJson']);

        Route::post('rent', [BrokerController::class, 'rent'])->name('broker.rent');
        Route::delete('reservation/destroy', [BrokerController::class, 'reservationDestroy'])->name('broker.reservation_destroy');
        Route::put('reservation/edit', [BrokerController::class, 'reservationEdit'])->name('broker.reservation_edit');
    });

    Route::group(['prefix' => 'owner', 'middleware' => ['owner']], function () {
        Route::get('', [OwnerController::class, 'index'])->name('owner.page');
        Route::get('unblock', [OwnerController::class, 'unblockPage'])->name('owner.unblock_page');
        Route::get('report', [OwnerController::class, 'report'])->name('owner.report');
        Route::get('properties', [OwnerController::class, 'properties'])->name('owner.properties');
        Route::get('contract/{propertyId}', [OwnerController::class, 'contract'])->name('owner.contract');
        
        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [OwnerController::class, 'getCalendarAsJson']);
        Route::get('getReport/{propertyId}', [OwnerController::class, 'getReport']);
        
        Route::post('contract', [OwnerController::class, 'createContract'])->name('owner.create_contract');
        Route::post('block', [OwnerController::class, 'block'])->name('owner.block');
        Route::post('unblock', [OwnerController::class, 'unblock'])->name('owner.unblock');
    });
});
