<?php

namespace Brainstream\Giftcard\Http\Requests;

use Brainstream\Giftcard\Services\GiftCardPurchase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $settings = app(GiftCardPurchase::class)->settings();

        return [
            'amount' => ['required', 'numeric', 'min:'.$settings['min_amount'], 'max:'.$settings['max_amount']],
            'occasion' => ['required', 'string', Rule::in(array_keys(config('giftcard.occasions', [])))],
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_email' => ['required', 'email', 'max:255'],
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'amount' => trans('giftcard::app.shop.purchase.amount', ['currency' => core()->getBaseCurrencyCode()]),
            'occasion' => trans('giftcard::app.shop.purchase.choose-occasion'),
            'recipient_name' => trans('giftcard::app.shop.purchase.recipient-name'),
            'recipient_email' => trans('giftcard::app.shop.purchase.recipient-email'),
            'sender_name' => trans('giftcard::app.shop.purchase.sender-name'),
            'sender_email' => trans('giftcard::app.shop.purchase.sender-email'),
            'message' => trans('giftcard::app.shop.purchase.message'),
        ];
    }
}
