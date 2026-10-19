@component('shop::emails.layout')
    @php
        $occasionImage = app(\Brainstream\Giftcard\Services\GiftCardPurchase::class)->occasionImageUrl($giftCard->occasion);

        $sender = $giftCard->sendername ?: core()->getCurrentChannel()->name;
    @endphp

    <div style="margin-bottom: 34px;">
        @if ($occasionImage)
            <img
                src="{{ $occasionImage }}"
                alt="{{ trans('giftcard::app.shop.occasions.'.$giftCard->occasion) }}"
                style="display: block; width: 100%; max-width: 560px; border-radius: 12px; margin-bottom: 24px;"
            >
        @endif

        <p style="font-size: 16px; color: #5E5E5E; line-height: 24px;">
            @lang('giftcard::app.emails.gift-card.greeting', ['name' => e($giftCard->recipientname ?: $giftCard->recipientemail)])
        </p>

        <p style="font-size: 16px; color: #5E5E5E; line-height: 24px;">
            @lang('giftcard::app.emails.gift-card.intro', [
                'sender' => e($sender),
                'amount' => core()->formatBasePrice($giftCard->giftcard_amount),
            ])
        </p>

        @if ($giftCard->occasion)
            <p style="font-size: 18px; font-weight: 600; color: #121A26; line-height: 26px;">
                @lang('giftcard::app.shop.greetings.'.$giftCard->occasion)
            </p>
        @endif

        @if ($giftCard->message)
            <p style="font-size: 16px; color: #5E5E5E; line-height: 24px; font-style: italic;">
                “{{ $giftCard->message }}”
            </p>
        @endif
    </div>

    <div style="padding: 24px; border: 1px dashed #2969FF; border-radius: 12px; text-align: center; margin-bottom: 24px;">
        <p style="font-size: 14px; color: #5E5E5E; margin: 0 0 8px;">
            @lang('giftcard::app.emails.gift-card.code')
        </p>

        <p style="font-size: 24px; font-weight: 700; letter-spacing: 2px; color: #121A26; margin: 0 0 8px;">
            {{ $giftCard->giftcard_number }}
        </p>

        <p style="font-size: 14px; color: #5E5E5E; margin: 0;">
            @lang('giftcard::app.emails.gift-card.expires', ['date' => core()->formatDate($giftCard->expirationdate, 'd M Y')])
        </p>
    </div>

    <p style="font-size: 16px; color: #5E5E5E; line-height: 24px;">
        @lang('giftcard::app.emails.gift-card.redeem')
    </p>

    <p style="margin-top: 24px;">
        <a
            href="{{ route('shop.home.index') }}"
            style="display: inline-block; padding: 12px 32px; border-radius: 8px; background: #060C3B; color: #FFFFFF; font-weight: 600; text-decoration: none;"
        >
            @lang('giftcard::app.emails.gift-card.shop-now')
        </a>
    </p>
@endcomponent
