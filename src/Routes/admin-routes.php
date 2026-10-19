<?php

use Brainstream\Giftcard\Http\Controllers\Admin\GiftCardController;
use Illuminate\Support\Facades\Route;
use Webkul\Core\Http\Middleware\NoCacheMiddleware;

Route::group([
    'middleware' => ['web', 'admin', NoCacheMiddleware::class],
    'prefix' => config('app.admin_url').'/gift-cards',
], function () {
    Route::controller(GiftCardController::class)->group(function () {
        Route::get('', 'index')->name('admin.gift_cards.index');

        Route::post('', 'store')->name('admin.gift_cards.store');

        Route::get('payments', 'payments')->name('admin.gift_cards.payments.index');

        Route::get('balances', 'balances')->name('admin.gift_cards.balances.index');

        Route::get('{id}', 'edit')->name('admin.gift_cards.edit');

        Route::put('{id}', 'update')->name('admin.gift_cards.update');

        Route::delete('{id}', 'destroy')->name('admin.gift_cards.delete');
    });
});
