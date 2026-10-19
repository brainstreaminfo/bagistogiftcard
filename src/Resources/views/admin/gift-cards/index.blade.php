<x-admin::layouts>
    <x-slot:title>
        @lang('giftcard::app.admin.gift-cards.title')
    </x-slot>

    <v-gift-cards>
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('giftcard::app.admin.gift-cards.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                @if (bouncer()->hasPermission('giftcard.gift_cards.create'))
                    <button
                        type="button"
                        class="primary-button"
                    >
                        @lang('giftcard::app.admin.gift-cards.create-btn')
                    </button>
                @endif
            </div>
        </div>

        <x-admin::shimmer.datagrid />
    </v-gift-cards>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-gift-cards-template"
        >
            <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    @lang('giftcard::app.admin.gift-cards.title')
                </p>

                <div class="flex items-center gap-x-2.5">
                    @if (bouncer()->hasPermission('giftcard.gift_cards.create'))
                        <button
                            type="button"
                            class="primary-button"
                            @click="openCreateModal"
                        >
                            @lang('giftcard::app.admin.gift-cards.create-btn')
                        </button>
                    @endif
                </div>
            </div>

            {!! view_render_event('bagisto.admin.gift_cards.list.before') !!}

            <x-admin::datagrid
                :src="route('admin.gift_cards.index')"
                ref="datagrid"
            >
                <template #body="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <template v-if="isLoading">
                        <x-admin::shimmer.datagrid.table.body />
                    </template>

                    <template v-else>
                        <div
                            v-for="record in available.records"
                            class="row grid items-center gap-2.5 border-b px-4 py-4 text-gray-600 transition-all hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-950"
                            :style="`grid-template-columns: repeat(${gridsCount}, minmax(0, 1fr))`"
                        >
                            <p>@{{ record.id }}</p>

                            <p class="break-all">@{{ record.giftcard_number }}</p>

                            <p>@{{ record.giftcard_amount }}</p>

                            <p class="break-all">@{{ record.recipientemail }}</p>

                            <p v-html="record.giftcard_status"></p>

                            <p>@{{ record.creationdate }}</p>

                            <p>@{{ record.expirationdate }}</p>

                            <div class="flex justify-end">
                                @if (bouncer()->hasPermission('giftcard.gift_cards.edit'))
                                    <a @click="openEditModal(record.actions.find(action => action.index === 'edit')?.url)">
                                        <span
                                            :class="record.actions.find(action => action.index === 'edit')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if (bouncer()->hasPermission('giftcard.gift_cards.delete'))
                                    <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                        <span
                                            :class="record.actions.find(action => action.index === 'delete')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </template>
                </template>
            </x-admin::datagrid>

            {!! view_render_event('bagisto.admin.gift_cards.list.after') !!}

            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <form
                    @submit="handleSubmit($event, updateOrCreate)"
                    ref="giftCardForm"
                >
                    <x-admin::modal ref="giftCardModal">
                        <x-slot:header>
                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-if="selectedGiftCard.id"
                            >
                                @lang('giftcard::app.admin.gift-cards.form.edit-title')
                            </p>

                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-else
                            >
                                @lang('giftcard::app.admin.gift-cards.form.create-title')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('bagisto.admin.gift_cards.form.before') !!}

                            <x-admin::form.control-group.control
                                type="hidden"
                                name="id"
                                v-model="selectedGiftCard.id"
                            />

                            <p
                                class="mb-4 text-sm text-gray-600 dark:text-gray-300"
                                v-if="selectedGiftCard.giftcard_number"
                            >
                                @lang('giftcard::app.admin.gift-cards.form.code'): <strong>@{{ selectedGiftCard.giftcard_number }}</strong>
                            </p>

                            <div class="flex gap-4 max-sm:flex-wrap">
                                <x-admin::form.control-group class="w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('giftcard::app.admin.gift-cards.form.amount', ['currency' => core()->getBaseCurrencyCode()])
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="giftcard_amount"
                                        rules="required|decimal|min_value:0"
                                        v-model="selectedGiftCard.giftcard_amount"
                                        :label="trans('giftcard::app.admin.gift-cards.form.amount', ['currency' => core()->getBaseCurrencyCode()])"
                                    />

                                    <x-admin::form.control-group.error control-name="giftcard_amount" />
                                </x-admin::form.control-group>

                                <x-admin::form.control-group
                                    class="w-full"
                                    v-if="! selectedGiftCard.id"
                                >
                                    <x-admin::form.control-group.label class="required">
                                        @lang('giftcard::app.admin.gift-cards.form.quantity')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="quantity"
                                        rules="required|numeric|min_value:1|max_value:50"
                                        v-model="selectedGiftCard.quantity"
                                        :label="trans('giftcard::app.admin.gift-cards.form.quantity')"
                                    />

                                    <x-admin::form.control-group.error control-name="quantity" />
                                </x-admin::form.control-group>
                            </div>

                            <div class="flex gap-4 max-sm:flex-wrap">
                                <x-admin::form.control-group class="w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('giftcard::app.admin.gift-cards.form.expires-on')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="date"
                                        name="expirationdate"
                                        rules="required"
                                        v-model="selectedGiftCard.expirationdate"
                                        :label="trans('giftcard::app.admin.gift-cards.form.expires-on')"
                                    />

                                    <x-admin::form.control-group.error control-name="expirationdate" />
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('giftcard::app.admin.gift-cards.form.status')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="select"
                                        name="giftcard_status"
                                        rules="required"
                                        v-model="selectedGiftCard.giftcard_status"
                                        :label="trans('giftcard::app.admin.gift-cards.form.status')"
                                    >
                                        <option value="1">@lang('giftcard::app.admin.gift-cards.datagrid.active')</option>

                                        <option value="0">@lang('giftcard::app.admin.gift-cards.datagrid.inactive')</option>
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error control-name="giftcard_status" />
                                </x-admin::form.control-group>
                            </div>

                            <div class="flex gap-4 max-sm:flex-wrap">
                                <x-admin::form.control-group class="w-full">
                                    <x-admin::form.control-group.label>
                                        @lang('giftcard::app.admin.gift-cards.form.recipient-name')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="recipientname"
                                        v-model="selectedGiftCard.recipientname"
                                        :label="trans('giftcard::app.admin.gift-cards.form.recipient-name')"
                                    />

                                    <x-admin::form.control-group.error control-name="recipientname" />
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full">
                                    <x-admin::form.control-group.label>
                                        @lang('giftcard::app.admin.gift-cards.form.recipient-email')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="email"
                                        name="recipientemail"
                                        rules="email"
                                        v-model="selectedGiftCard.recipientemail"
                                        :label="trans('giftcard::app.admin.gift-cards.form.recipient-email')"
                                    />

                                    <x-admin::form.control-group.error control-name="recipientemail" />
                                </x-admin::form.control-group>
                            </div>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('giftcard::app.admin.gift-cards.form.message')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    name="message"
                                    rules="max:500"
                                    v-model="selectedGiftCard.message"
                                    :label="trans('giftcard::app.admin.gift-cards.form.message')"
                                />

                                <x-admin::form.control-group.error control-name="message" />
                            </x-admin::form.control-group>

                            <p
                                class="text-xs text-gray-600 dark:text-gray-300"
                                v-if="! selectedGiftCard.id"
                            >
                                @lang('giftcard::app.admin.gift-cards.form.email-note')
                            </p>

                            {!! view_render_event('bagisto.admin.gift_cards.form.after') !!}
                        </x-slot>

                        <x-slot:footer>
                            <x-admin::button
                                button-type="button"
                                class="primary-button"
                                :title="trans('giftcard::app.admin.gift-cards.form.save-btn')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-admin::modal>
                </form>
            </x-admin::form>
        </script>

        <script type="module">
            app.component('v-gift-cards', {
                template: '#v-gift-cards-template',

                data() {
                    return {
                        isLoading: false,

                        selectedGiftCard: {},
                    };
                },

                computed: {
                    gridsCount() {
                        let count = this.$refs.datagrid.available.columns.length;

                        if (this.$refs.datagrid.available.actions.length) {
                            ++count;
                        }

                        if (this.$refs.datagrid.available.massActions.length) {
                            ++count;
                        }

                        return count;
                    },
                },

                methods: {
                    openCreateModal() {
                        this.selectedGiftCard = {
                            quantity: 1,
                            giftcard_status: '1',
                        };

                        this.$refs.giftCardModal.toggle();
                    },

                    openEditModal(url) {
                        this.$axios.get(url)
                            .then((response) => {
                                this.selectedGiftCard = response.data;

                                this.$refs.giftCardModal.toggle();
                            })
                            .catch((error) => {
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },

                    updateOrCreate(params, { resetForm, setErrors }) {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.giftCardForm);

                        let url = "{{ route('admin.gift_cards.store') }}";

                        if (params.id) {
                            formData.append('_method', 'put');

                            url = "{{ route('admin.gift_cards.update', ':id') }}".replace(':id', params.id);
                        }

                        this.$axios.post(url, formData)
                            .then((response) => {
                                this.isLoading = false;

                                this.$refs.giftCardModal.close();

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.$refs.datagrid.get();

                                resetForm();
                            })
                            .catch((error) => {
                                this.isLoading = false;

                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
