<x-shop::layouts>
    <x-slot:title>
        @lang('giftcard::app.shop.success.title')
    </x-slot>

    <div class="gc-shell">
        <section class="gc-success">
            <span
                class="gc-success-icon"
                aria-hidden="true"
            >
                <svg viewBox="0 0 24 24"><path d="m5 12 5 5 9-10" /></svg>
            </span>

            <h1 class="gc-hero-title">
                @lang('giftcard::app.shop.success.title')
            </h1>

            <p class="gc-hero-lead">
                @lang('giftcard::app.shop.success.message', [
                    'amount' => '<strong>'.e($purchase['amount']).'</strong>',
                    'email' => '<strong>'.e($purchase['email']).'</strong>',
                ])
            </p>

            <img
                class="gc-success-art"
                src="{{ asset('vendor/giftcard/images/occasions/thank-you.jpg') }}"
                alt=""
            >

            <p class="gc-note">
                @lang('giftcard::app.shop.success.next-steps')
            </p>

            <div class="gc-success-actions">
                <a
                    href="{{ route('shop.gift_cards.index') }}"
                    class="gc-button"
                >
                    @lang('giftcard::app.shop.success.buy-another')
                </a>

                <a
                    href="{{ route('shop.home.index') }}"
                    class="gc-button gc-button-outline"
                >
                    @lang('giftcard::app.shop.success.continue-shopping')
                </a>
            </div>
        </section>
    </div>
</x-shop::layouts>
