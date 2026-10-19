<?php

use Brainstream\Giftcard\Http\Controllers\Shop\CartGiftCardController;
use Brainstream\Giftcard\Http\Controllers\Shop\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'shop']], function () {
    Route::controller(PurchaseController::class)->prefix('gift-cards')->group(function () {
        Route::get('', 'index')->name('shop.gift_cards.index');

        Route::get('success', 'success')->name('shop.gift_cards.success');

        Route::post('paypal/create-order', 'createOrder')
            ->middleware('throttle:10,1')
            ->name('shop.gift_cards.paypal.create_order');

        Route::post('paypal/capture-order', 'captureOrder')
            ->middleware('throttle:10,1')
            ->name('shop.gift_cards.paypal.capture_order');
    });

    Route::controller(CartGiftCardController::class)->prefix('api/checkout/cart/gift-card')->group(function () {
        Route::get('', 'show')->name('shop.api.checkout.cart.gift_card.show');

        Route::post('', 'store')
            ->middleware('throttle:10,1')
            ->name('shop.api.checkout.cart.gift_card.store');

        Route::delete('', 'destroy')->name('shop.api.checkout.cart.gift_card.destroy');
    });
});
