<v-gift-card
    :cart="cart"
    @gift-card-changed="getCart"
>
</v-gift-card>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-gift-card-template"
    >
        <div class="gc-checkout">
            <template v-if="giftCard.applied">
                <div class="flex justify-between text-right">
                    <p class="text-base max-sm:text-sm">
                        @{{ labels.applied.replace(':code', giftCard.code) }}

                        <button
                            type="button"
                            class="gc-link gc-link-danger"
                            :disabled="isLoading"
                            @click="remove"
                        >
                            @lang('giftcard::app.shop.checkout.remove')
                        </button>
                    </p>

                    <p class="text-base font-medium max-sm:text-sm">
                        - @{{ giftCard.formatted_amount }}
                    </p>
                </div>

                <p class="gc-note">
                    @{{ labels.remaining.replace(':amount', giftCard.formatted_remaining) }}
                </p>
            </template>

            <template v-else>
                <p class="text-base max-sm:text-sm">
                    @lang('giftcard::app.shop.checkout.title')
                </p>

                <form
                    class="gc-inline-form"
                    @submit.prevent="apply"
                >
                    <input
                        type="text"
                        class="gc-input"
                        v-model.trim="code"
                        maxlength="100"
                        placeholder="@lang('giftcard::app.shop.checkout.placeholder')"
                        aria-label="@lang('giftcard::app.shop.checkout.placeholder')"
                    />

                    <button
                        type="submit"
                        class="gc-button"
                        :disabled="isLoading || ! code"
                    >
                        @lang('giftcard::app.shop.checkout.apply')
                    </button>
                </form>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-gift-card', {
            template: '#v-gift-card-template',

            props: ['cart'],

            emits: ['gift-card-changed'],

            data() {
                return {
                    code: '',

                    isLoading: false,

                    giftCard: { applied: false },

                    labels: {
                        applied: @json(trans('giftcard::app.shop.checkout.applied')),
                        remaining: @json(trans('giftcard::app.shop.checkout.remaining')),
                    },
                };
            },

            watch: {
                'cart.grand_total'() {
                    this.load();
                },
            },

            mounted() {
                this.load();
            },

            methods: {
                load() {
                    this.$axios.get("{{ route('shop.api.checkout.cart.gift_card.show') }}")
                        .then((response) => {
                            this.giftCard = response.data.data;
                        })
                        .catch(() => {});
                },

                apply() {
                    this.isLoading = true;

                    this.$axios.post("{{ route('shop.api.checkout.cart.gift_card.store') }}", { code: this.code })
                        .then((response) => {
                            this.giftCard = response.data.data;

                            this.code = '';

                            this.$emit('gift-card-changed');

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch((error) => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message });
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                },

                remove() {
                    this.isLoading = true;

                    this.$axios.delete("{{ route('shop.api.checkout.cart.gift_card.destroy') }}")
                        .then((response) => {
                            this.giftCard = response.data.data;

                            this.$emit('gift-card-changed');

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch((error) => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message });
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                },
            },
        });
    </script>
@endPushOnce
