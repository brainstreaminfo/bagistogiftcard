<?php

namespace Brainstream\Giftcard\Http\Controllers\Shop;

use Brainstream\Giftcard\Services\GiftCardManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Webkul\Checkout\Facades\Cart;
use Webkul\Shop\Http\Controllers\Controller;

class CartGiftCardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected GiftCardManager $giftCardManager) {}

    /**
     * Return the gift card applied to the cart.
     */
    public function show(): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->giftCardState(),
        ]);
    }

    /**
     * Apply a gift card to the cart.
     */
    public function store(): JsonResponse
    {
        $this->validate(request(), [
            'code' => ['required', 'string', 'max:100'],
        ]);

        $cart = Cart::getCart();

        if (! $cart) {
            return new JsonResponse([
                'message' => trans('giftcard::app.shop.checkout.cart-not-found'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $giftCard = $this->giftCardManager->findRedeemable(request()->input('code'));

        if (! $giftCard) {
            return new JsonResponse([
                'data' => $this->giftCardState(),
                'message' => trans('giftcard::app.shop.checkout.invalid'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cart->giftcard_number = $giftCard->giftcard_number;

        $cart->save();

        Cart::collectTotals();

        return new JsonResponse([
            'data' => $this->giftCardState(),
            'message' => trans('giftcard::app.shop.checkout.apply-success'),
        ]);
    }

    /**
     * Remove the gift card from the cart.
     */
    public function destroy(): JsonResponse
    {
        $cart = Cart::getCart();

        if ($cart) {
            $cart->giftcard_number = null;
            $cart->giftcard_amount = null;
            $cart->base_giftcard_amount = null;
            $cart->remaining_giftcard_amount = 0;

            $cart->save();

            Cart::collectTotals();
        }

        return new JsonResponse([
            'data' => $this->giftCardState(),
            'message' => trans('giftcard::app.shop.checkout.remove-success'),
        ]);
    }

    /**
     * Describe the gift card applied to the current cart.
     */
    protected function giftCardState(): array
    {
        $cart = Cart::getCart();

        if (
            ! $cart
            || ! $cart->giftcard_number
        ) {
            return ['applied' => false];
        }

        return [
            'applied' => true,
            'code' => $cart->giftcard_number,
            'formatted_amount' => core()->formatPrice((float) $cart->giftcard_amount, $cart->cart_currency_code),
            'formatted_remaining' => core()->formatBasePrice((float) $cart->remaining_giftcard_amount),
        ];
    }
}
