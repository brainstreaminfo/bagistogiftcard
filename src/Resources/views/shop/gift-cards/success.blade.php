<x-shop::layouts>
    <x-slot:title>
        @lang('giftcard::app.shop.success.title')
    </x-slot>

    <div class="container mt-8 px-15 max-lg:px-8 max-md:px-4">
        <div class="gc-page gc-success">
            <img
                src="{{ asset('vendor/giftcard/images/occasions/thank-you.jpg') }}"
                alt="@lang('giftcard::app.shop.success.title')"
            >

            <h1 class="gc-title">
                @lang('giftcard::app.shop.success.title')
            </h1>

            <p class="gc-subtitle">
                @lang('giftcard::app.shop.success.message', [
                    'amount' => e($purchase['amount']),
                    'email' => e($purchase['email']),
                ])
            </p>

            <a
                href="{{ route('shop.home.index') }}"
                class="gc-button"
            >
                @lang('giftcard::app.shop.success.continue-shopping')
            </a>
        </div>
    </div>
</x-shop::layouts>
