@php
    $giftCardOrder = auth()->guard('customer')->user()?->orders()->find(request()->route('id'));
@endphp

@if ((float) $giftCardOrder?->base_giftcard_amount > 0)
    <div class="flex w-full justify-between gap-x-5">
        <p class="text-zinc-500">
            @lang('giftcard::app.shop.order.gift-card', ['code' => $giftCardOrder->giftcard_number])
        </p>

        <p>
            - {{ core()->formatPrice((float) $giftCardOrder->giftcard_amount, $giftCardOrder->order_currency_code) }}
        </p>
    </div>
@endif
