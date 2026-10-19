@php
    $giftCardTotals = app(\Brainstream\Giftcard\Services\GiftCardTotals::class);

    $giftCardDocument = $giftCardTotals->nextForStorefrontHook('invoices');

    $giftCardOrder = $giftCardTotals->giftCardOrder($giftCardDocument);
@endphp

@if ($giftCardOrder)
    <div class="flex w-full justify-between gap-x-5">
        <p class="text-zinc-500">
            {{ $giftCardTotals->label($giftCardOrder) }}
        </p>

        <p>
            - {{ core()->formatPrice((float) $giftCardDocument->giftcard_amount, $giftCardOrder->order_currency_code) }}
        </p>
    </div>
@endif
