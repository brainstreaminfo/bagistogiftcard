<?php

namespace Brainstream\Giftcard\Http\Requests;

use Brainstream\Giftcard\Models\GiftCard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GiftCardRequest extends FormRequest
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
        $rules = [
            'giftcard_amount' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'expirationdate' => ['required', 'date'],
            'giftcard_status' => ['required', Rule::in([GiftCard::STATUS_ACTIVE, GiftCard::STATUS_INACTIVE])],
            'recipientname' => ['nullable', 'string', 'max:255'],
            'recipientemail' => ['nullable', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
        ];

        if ($this->isMethod('post')) {
            $rules['giftcard_amount'][2] = 'gt:0';
            $rules['expirationdate'][] = 'after_or_equal:today';
            $rules['quantity'] = ['required', 'integer', 'min:1', 'max:50'];
        }

        return $rules;
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'giftcard_amount' => trans('giftcard::app.admin.gift-cards.form.amount'),
            'expirationdate' => trans('giftcard::app.admin.gift-cards.form.expires-on'),
            'giftcard_status' => trans('giftcard::app.admin.gift-cards.form.status'),
            'recipientname' => trans('giftcard::app.admin.gift-cards.form.recipient-name'),
            'recipientemail' => trans('giftcard::app.admin.gift-cards.form.recipient-email'),
            'message' => trans('giftcard::app.admin.gift-cards.form.message'),
            'quantity' => trans('giftcard::app.admin.gift-cards.form.quantity'),
        ];
    }
}
