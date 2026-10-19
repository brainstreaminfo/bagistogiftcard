@php
    $giftCardOrder = app(\Webkul\Sales\Repositories\OrderRepository::class)->find(request()->route('id'));
@endphp

@if ((float) $giftCardOrder?->base_giftcard_amount > 0)
    <div class="flex w-full justify-between gap-x-5">
        <p class="text-gray-600 dark:text-gray-300">
            @lang('giftcard::app.admin.sales.gift-card') ({{ $giftCardOrder->giftcard_number }})
        </p>

        <p class="text-gray-600 dark:text-gray-300">
            - {{ core()->formatBasePrice((float) $giftCardOrder->base_giftcard_amount) }}
        </p>
    </div>
@endif
