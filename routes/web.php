<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('auth', [LoginController::class, 'auth'])->name('auth.user');

Route::get('contract/{contractId}/download', [OwnerController::class, 'downloadPropertyContract'])->name('owner.download_property_contract');
Route::get('contract/{contractId}/client', [OwnerController::class, 'contractClient'])->name('owner.property_contract_client');
Route::post('contract/{contractId}/client', [OwnerController::class, 'saveContractClient'])->name('owner.client_signature');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout.user');

    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
        Route::get('', [AdminController::class, 'index'])->name('admin.page');
        Route::get('unblock', [AdminController::class, 'unblockPage'])->name('admin.unblock_page');
        Route::get('report', [AdminController::class, 'report'])->name('admin.report');

        Route::group(['prefix' => 'reservation'], function () {
            Route::get('', [AdminController::class, 'reservation'])->name('admin.reservation');
            Route::get('{id}', [AdminController::class, 'reservation'])->name('admin.reservation_edit_page');
        });

        Route::group(['prefix' => 'reservations'], function () {
            Route::get('', [AdminController::class, 'reservations'])->name('admin.reservations');
            Route::get('{id}', [AdminController::class, 'reservationDetails'])->name('admin.reservations_details');
            Route::get('{id}/contract', [AdminController::class, 'downloadContract'])->name('admin.download_contract');
        });


        Route::group(['prefix' => 'report'], function () {
            Route::get('', [AdminController::class, 'report'])->name('admin.report');
            Route::get('indication', [AdminController::class, 'reportIndication'])->name('admin.report_indication');
            Route::get('regional', [AdminController::class, 'reportRegional'])->name('admin.report_regional');
        });

        Route::get('properties', [AdminController::class, 'properties'])->name('admin.properties');
        Route::get('properties/heat', [AdminController::class, 'propertiesHeat'])->name('admin.properties_heat');

        Route::group(['prefix' => 'property'], function () {
            Route::get('{id}/contract', [AdminController::class, 'downloadContractProperty'])->name('admin.download_contract_property');
            Route::get('{propertyId}/indication', [AdminController::class, 'propertyIndication'])->name('admin.property_indication');
            Route::get('{propertyId}/standard', [AdminController::class, 'propertyStandard'])->name('admin.property_standard');
        });

        Route::get('receipts', [AdminController::class, 'receipts'])->name('admin.receipts');
        Route::get('verify', [AdminController::class, 'verify'])->name('admin.verify');
        Route::get('search-properties', [AdminController::class, 'searchProperties'])->name('admin.search_properties');

        Route::group(['prefix' => 'demand'], function () {
            Route::get('', [AdminController::class, 'demand'])->name('admin.demand');
            Route::post('', [AdminController::class, 'createDemand'])->name('admin.save_demand');
        });

        Route::group(['prefix' => 'reminder'], function () {
            Route::get('', [AdminController::class, 'reminder'])->name('admin.reminder');
            Route::get('{id}', [AdminController::class, 'viewReminder'])->name('admin.show_reminder');
            Route::post('', [AdminController::class, 'createReminder'])->name('admin.store_reminder');
            Route::delete('{id}', [AdminController::class, 'deleteReminder'])->name('admin.delete_reminder');
        });

        Route::group(['prefix' => 'client'], function () {
            Route::get('', [AdminController::class, 'viewClients'])->name('admin.clients');
            Route::get('{clientId}', [AdminController::class, 'showClient'])->name('admin.client');
            Route::post('', [AdminController::class, 'saveClient'])->name('admin.save_client');
            Route::post('{clientId}', [AdminController::class, 'approveClient'])->name('admin.approve_client');
            Route::delete('{clientId}', [AdminController::class, 'destroyClient'])->name('admin.destroy_client');
        });

        Route::group(['prefix' => 'indication'], function () {
            Route::get('', [AdminController::class, 'viewIndications'])->name('admin.indications');
            Route::get('{indicationId}', [AdminController::class, 'showIndication'])->name('admin.indication');
            Route::post('{indicationId}/answered', [AdminController::class, 'answeredIndication'])->name('admin.answered_indication');
            Route::post('{indicationId}/reserved', [AdminController::class, 'reservedIndication'])->name('admin.reserved_indication');
            Route::delete('{indicationId}', [AdminController::class, 'destroyIndication'])->name('admin.destroy_indication');
        });

        Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::get('social', [AdminController::class, 'social'])->name('admin.social_media');
        Route::get('contracts', [AdminController::class, 'contracts'])->name('admin.contracts');

        Route::get('getProperty/{propertyId}', [AdminController::class, 'getProperty'])->name('admin.property');
        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [AdminController::class, 'getCalendarAsJson']);
        Route::get('getReport/{propertyId}', [AdminController::class, 'getReport']);
        Route::get('getReservations/{propertyId}/{month}/{year}', [AdminController::class, 'getReservations']);
        Route::get('getPropertyHeat/{propertyId}/{month}/{year}', [AdminController::class, 'getPropertyHeat']);

        Route::post('receipts', [AdminController::class, 'createReceipt'])->name('admin.create_receipt');
        Route::post('block', [AdminController::class, 'block'])->name('admin.block');
        Route::post('unblock', [AdminController::class, 'unblock'])->name('admin.unblock');
        Route::post('rent', [AdminController::class, 'rent'])->name('admin.rent');
        Route::post('property', [AdminController::class, 'propertyInfo'])->name('admin.property_info');
        Route::post('verify', [AdminController::class, 'verified'])->name('admin.verified');
        Route::post('verify/property', [AdminController::class, 'verifiedProperty'])->name('admin.verified_property');
        Route::post('refuse', [AdminController::class, 'refuse'])->name('admin.refuse');
        Route::delete('reservation/destroy', [AdminController::class, 'reservationDestroy'])->name('admin.reservation_destroy');
    });

    Route::group(['prefix' => 'broker', 'middleware' => ['broker']], function () {
        Route::get('', [BrokerController::class, 'index'])->name('broker.page');
        Route::get('{id}', [BrokerController::class, 'index'])->name('broker.reservation_edit');

        Route::group(['prefix' => 'reservations'], function () {
            Route::get('', [BrokerController::class, 'reservations'])->name('broker.reservations');
            Route::get('{id}', [BrokerController::class, 'reservationDetails'])->name('broker.reservations_details');
            Route::get('{id}/contract', [BrokerController::class, 'downloadContract'])->name('broker.download_contract');
        });

        Route::get('report', [BrokerController::class, 'report'])->name('broker.report');

        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [BrokerController::class, 'getCalendarAsJson']);
        Route::get('getReservations/{propertyId}/{month}/{year}', [BrokerController::class, 'getReservations']);

        Route::post('rent', [BrokerController::class, 'rent'])->name('broker.rent');
        Route::delete('reservation/destroy', [BrokerController::class, 'reservationDestroy'])->name('broker.reservation_destroy');
    });

    Route::group(['prefix' => 'owner', 'middleware' => ['owner']], function () {
        Route::get('', [OwnerController::class, 'index'])->name('owner.page');
        Route::get('unblock', [OwnerController::class, 'unblockPage'])->name('owner.unblock_page');
        Route::get('report', [OwnerController::class, 'report'])->name('owner.report');

        Route::group(['prefix' => 'reservations'], function () {
            Route::get('', [OwnerController::class, 'reservations'])->name('owner.reservations');
            Route::get('{id}', [OwnerController::class, 'reservationDetails'])->name('owner.reservations_details');
            Route::get('{id}/contract', [OwnerController::class, 'downloadContract'])->name('owner.download_contract');
        });

        Route::group(['prefix' => 'properties'], function () {
            Route::get('', [OwnerController::class, 'properties'])->name('owner.properties');
            Route::get('contracts', [OwnerController::class, 'propertiesContracts'])->name('owner.properties_contracts');
        });

        Route::group(['prefix' => 'property'], function () {
            Route::get('{propertyId}/documents', [OwnerController::class, 'propertyDocuments'])->name('owner.property_documents');
            Route::get('{propertyId}/contract', [OwnerController::class, 'contract'])->name('owner.contract');
        });

        Route::group(['prefix' => 'contract'], function () {
            Route::get('{contractId}/owner', [OwnerController::class, 'contractOwner'])->name('owner.property_contract');
            Route::post('', [OwnerController::class, 'createContract'])->name('owner.create_contract');
            Route::post('{contractId}/owner', [OwnerController::class, 'saveContractOwner'])->name('owner.owner_signature');
            Route::delete('{contractId}', [OwnerController::class, 'destroyContract'])->name('owner.destroy_contract');
        });

        Route::group(['prefix' => 'client'], function () {
            Route::get('', [OwnerController::class, 'viewClients'])->name('owner.clients');
            Route::get('new', [OwnerController::class, 'createClient'])->name('owner.create_client');
            Route::get('{clientId}', [OwnerController::class, 'showClient'])->name('owner.client');
            Route::post('', [OwnerController::class, 'saveClient'])->name('owner.save_client');
            Route::delete('{clientId}', [OwnerController::class, 'destroyClient'])->name('owner.destroy_client');
        });

        Route::group(['prefix' => 'indication'], function () {
            Route::get('', [OwnerController::class, 'viewIndications'])->name('owner.indications');
            Route::get('new', [OwnerController::class, 'createIndication'])->name('owner.create_indication');
            Route::get('{indicationId}', [OwnerController::class, 'showIndication'])->name('owner.indication');
            Route::post('', [OwnerController::class, 'saveIndication'])->name('owner.save_indication');
            Route::delete('{indicationId}', [OwnerController::class, 'destroyIndication'])->name('owner.destroy_indication');
        });

        Route::get('value/{propertyId}', [OwnerController::class, 'value'])->name('owner.value');
        Route::get('receipts/{id}', [OwnerController::class, 'downloadReceipt'])->name('owner.download_receipt');
        Route::get('demands', [OwnerController::class, 'demands'])->name('owner.demands');

        Route::get('getCalendar/{propertyId}/{monthId}/{yearId}', [OwnerController::class, 'getCalendarAsJson']);
        Route::get('getReservations/{propertyId}/{month}/{year}', [OwnerController::class, 'getReservations']);
        Route::get('getReport/{propertyId}', [OwnerController::class, 'getReport']);

        Route::post('property/documents', [OwnerController::class, 'sendPropertyDocuments'])->name('owner.send_property_documents');
        Route::post('value', [OwnerController::class, 'saveValue'])->name('owner.save_value');
        Route::post('block', [OwnerController::class, 'block'])->name('owner.block');
        Route::post('unblock', [OwnerController::class, 'unblock'])->name('owner.unblock');
        Route::delete('reservation/destroy', [OwnerController::class, 'reservationDestroy'])->name('owner.reservation_destroy');
    });
});
