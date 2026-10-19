<x-admin::layouts>
    <x-slot:title>
        @lang('giftcard::app.admin.payments.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('giftcard::app.admin.payments.title')
        </p>
    </div>

    {!! view_render_event('bagisto.admin.gift_cards.payments.list.before') !!}

    <x-admin::datagrid :src="route('admin.gift_cards.payments.index')" />

    {!! view_render_event('bagisto.admin.gift_cards.payments.list.after') !!}
</x-admin::layouts>
