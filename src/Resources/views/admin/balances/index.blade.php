<x-admin::layouts>
    <x-slot:title>
        @lang('giftcard::app.admin.balances.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('giftcard::app.admin.balances.title')
        </p>
    </div>

    {!! view_render_event('bagisto.admin.gift_cards.balances.list.before') !!}

    <x-admin::datagrid :src="route('admin.gift_cards.balances.index')" />

    {!! view_render_event('bagisto.admin.gift_cards.balances.list.after') !!}
</x-admin::layouts>
