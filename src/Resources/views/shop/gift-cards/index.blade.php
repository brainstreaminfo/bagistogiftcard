<x-shop::layouts>
    <x-slot:title>
        @lang('giftcard::app.shop.purchase.title')
    </x-slot>

    <div class="container mt-8 px-15 max-lg:px-8 max-md:px-4">
        <div class="gc-page">
            <h1 class="gc-title">
                @lang('giftcard::app.shop.purchase.title')
            </h1>

            <p class="gc-subtitle">
                @lang('giftcard::app.shop.purchase.description')
            </p>

            {!! view_render_event('bagisto.shop.gift_cards.purchase.before') !!}

            @if (! $isAvailable)
                <p class="gc-alert">
                    @lang('giftcard::app.shop.purchase.unavailable')
                </p>
            @elseif (! $isCurrencySupported)
                <p class="gc-alert">
                    @lang('giftcard::app.shop.purchase.currency-unsupported', ['currency' => $settings['currency']])
                </p>
            @else
                <v-gift-card-purchase></v-gift-card-purchase>
            @endif

            {!! view_render_event('bagisto.shop.gift_cards.purchase.after') !!}
        </div>
    </div>

    @if (
        $isAvailable
        && $isCurrencySupported
    )
        @pushOnce('scripts')
            <script
                src="https://www.paypal.com/sdk/js?client-id={{ urlencode($settings['client_id']) }}&currency={{ $settings['currency'] }}"
                data-partner-attribution-id="Bagisto_Cart"
            >
            </script>

            <script
                type="text/x-template"
                id="v-gift-card-purchase-template"
            >
                <div>
                    <div v-show="step === 'occasion'">
                        <h2 class="gc-heading">
                            @lang('giftcard::app.shop.purchase.choose-occasion')
                        </h2>

                        <div class="gc-occasions">
                            <button
                                type="button"
                                class="gc-occasion"
                                :class="{ 'gc-occasion-selected': form.occasion === occasion.key }"
                                v-for="occasion in occasions"
                                :key="occasion.key"
                                @click="selectOccasion(occasion)"
                            >
                                <img
                                    :src="occasion.image"
                                    :alt="occasion.name"
                                    loading="lazy"
                                >

                                <span>@{{ occasion.name }}</span>
                            </button>
                        </div>

                        <p
                            class="gc-error"
                            v-if="errors.occasion"
                        >
                            @{{ errors.occasion }}
                        </p>
                    </div>

                    <div
                        class="gc-details"
                        v-if="step === 'details'"
                    >
                        <div class="gc-preview">
                            <img
                                :src="selectedOccasion.image"
                                :alt="selectedOccasion.name"
                            >

                            <div class="gc-preview-body">
                                <p class="gc-preview-greeting">@{{ selectedOccasion.greeting }}</p>

                                <p class="gc-preview-amount">@{{ formattedAmount }}</p>

                                <p
                                    class="gc-preview-message"
                                    v-if="form.message"
                                >
                                    “@{{ form.message }}”
                                </p>

                                <p
                                    class="gc-preview-from"
                                    v-if="form.sender_name"
                                >
                                    — @{{ form.sender_name }}
                                </p>
                            </div>
                        </div>

                        <div class="gc-form">
                            <h2 class="gc-heading">
                                @lang('giftcard::app.shop.purchase.details')
                            </h2>

                            <label class="gc-label required">
                                @lang('giftcard::app.shop.purchase.amount', ['currency' => $settings['currency']])
                            </label>

                            <div class="gc-amounts">
                                <button
                                    type="button"
                                    class="gc-amount"
                                    :class="{ 'gc-amount-selected': Number(form.amount) === preset }"
                                    v-for="preset in presets"
                                    :key="preset"
                                    @click="form.amount = preset"
                                >
                                    @{{ preset }}
                                </button>
                            </div>

                            <input
                                type="number"
                                class="gc-input"
                                v-model="form.amount"
                                :min="settings.min_amount"
                                :max="settings.max_amount"
                                step="0.01"
                            >

                            <p class="gc-note">
                                @lang('giftcard::app.shop.purchase.amount-range', [
                                    'min' => core()->formatBasePrice($settings['min_amount']),
                                    'max' => core()->formatBasePrice($settings['max_amount']),
                                ])
                            </p>

                            <p
                                class="gc-error"
                                v-if="errors.amount"
                            >
                                @{{ errors.amount }}
                            </p>

                            <div
                                class="gc-field"
                                v-for="field in fields"
                                :key="field.name"
                            >
                                <label
                                    class="gc-label"
                                    :class="{ required: field.required }"
                                    :for="'gc-' + field.name"
                                >
                                    @{{ field.label }}
                                </label>

                                <textarea
                                    class="gc-input"
                                    rows="3"
                                    maxlength="500"
                                    :id="'gc-' + field.name"
                                    v-model="form[field.name]"
                                    v-if="field.type === 'textarea'"
                                ></textarea>

                                <input
                                    class="gc-input"
                                    maxlength="255"
                                    :type="field.type"
                                    :id="'gc-' + field.name"
                                    v-model="form[field.name]"
                                    v-else
                                >

                                <p
                                    class="gc-error"
                                    v-if="errors[field.name]"
                                >
                                    @{{ errors[field.name] }}
                                </p>
                            </div>

                            <div class="gc-actions">
                                <button
                                    type="button"
                                    class="gc-link"
                                    @click="step = 'occasion'"
                                >
                                    @lang('giftcard::app.shop.purchase.back')
                                </button>
                            </div>

                            <p class="gc-heading gc-pay-heading">
                                @lang('giftcard::app.shop.purchase.pay')
                            </p>

                            <div
                                class="gc-paypal"
                                ref="paypalContainer"
                            ></div>
                        </div>
                    </div>
                </div>
            </script>

            <script type="module">
                app.component('v-gift-card-purchase', {
                    template: '#v-gift-card-purchase-template',

                    data() {
                        return {
                            step: 'occasion',

                            settings: @json($settings),

                            occasions: @json($occasions),

                            selectedOccasion: null,

                            errors: {},

                            messages: {
                                required: @json(trans('giftcard::app.shop.purchase.required')),
                                invalidEmail: @json(trans('giftcard::app.shop.purchase.invalid-email')),
                                fixErrors: @json(trans('giftcard::app.shop.purchase.fix-errors')),
                                amountRange: @json(trans('giftcard::app.shop.purchase.amount-range', ['min' => core()->formatBasePrice($settings['min_amount']), 'max' => core()->formatBasePrice($settings['max_amount'])])),
                            },

                            form: {
                                occasion: '',
                                amount: @json($settings['preset_amounts'][0] ?? $settings['min_amount']),
                                recipient_name: '',
                                recipient_email: '',
                                sender_name: @json(trim(auth()->guard('customer')->user()?->first_name.' '.auth()->guard('customer')->user()?->last_name)),
                                sender_email: @json(auth()->guard('customer')->user()?->email ?? ''),
                                message: '',
                            },

                            fields: [
                                { name: 'recipient_name', type: 'text', required: true, label: @json(trans('giftcard::app.shop.purchase.recipient-name')) },
                                { name: 'recipient_email', type: 'email', required: true, label: @json(trans('giftcard::app.shop.purchase.recipient-email')) },
                                { name: 'sender_name', type: 'text', required: true, label: @json(trans('giftcard::app.shop.purchase.sender-name')) },
                                { name: 'sender_email', type: 'email', required: true, label: @json(trans('giftcard::app.shop.purchase.sender-email')) },
                                { name: 'message', type: 'textarea', required: false, label: @json(trans('giftcard::app.shop.purchase.message')) },
                            ],
                        };
                    },

                    computed: {
                        presets() {
                            return this.settings.preset_amounts.filter((amount) => {
                                return amount >= this.settings.min_amount
                                    && amount <= this.settings.max_amount;
                            });
                        },

                        formattedAmount() {
                            let amount = Number(this.form.amount) || 0;

                            return new Intl.NumberFormat(document.documentElement.lang || 'en', {
                                style: 'currency',
                                currency: this.settings.currency,
                            }).format(amount);
                        },
                    },

                    methods: {
                        selectOccasion(occasion) {
                            this.selectedOccasion = occasion;

                            this.form.occasion = occasion.key;

                            this.errors = {};

                            this.step = 'details';

                            this.$nextTick(() => this.renderPaypalButtons());
                        },

                        renderPaypalButtons() {
                            if (typeof paypal === 'undefined') {
                                this.$emitter.emit('add-flash', { type: 'error', message: @json(trans('giftcard::app.shop.purchase.unavailable')) });

                                return;
                            }

                            this.$refs.paypalContainer.innerHTML = '';

                            paypal.Buttons({
                                style: {
                                    layout: 'vertical',
                                    shape: 'rect',
                                },

                                onClick: (data, actions) => {
                                    this.errors = this.validateForm();

                                    if (Object.keys(this.errors).length) {
                                        this.showErrors();

                                        return actions.reject();
                                    }

                                    return actions.resolve();
                                },

                                createOrder: () => {
                                    this.errors = {};

                                    return this.$axios.post("{{ route('shop.gift_cards.paypal.create_order') }}", this.form)
                                        .then((response) => response.data.id)
                                        .catch((error) => {
                                            this.handleError(error);

                                            throw error;
                                        });
                                },

                                onApprove: (data) => {
                                    return this.$axios.post("{{ route('shop.gift_cards.paypal.capture_order') }}", { order_id: data.orderID })
                                        .then((response) => {
                                            window.location.href = response.data.redirect_url;
                                        })
                                        .catch((error) => this.handleError(error));
                                },

                                onError: () => {},
                            }).render(this.$refs.paypalContainer);
                        },

                        validateForm() {
                            let errors = {};

                            let amount = Number(this.form.amount);

                            if (
                                ! amount
                                || amount < this.settings.min_amount
                                || amount > this.settings.max_amount
                            ) {
                                errors.amount = this.messages.amountRange;
                            }

                            this.fields.forEach((field) => {
                                let value = String(this.form[field.name] || '').trim();

                                if (
                                    field.required
                                    && ! value
                                ) {
                                    errors[field.name] = this.messages.required;
                                } else if (
                                    field.type === 'email'
                                    && value
                                    && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                                ) {
                                    errors[field.name] = this.messages.invalidEmail;
                                }
                            });

                            return errors;
                        },

                        showErrors() {
                            this.$emitter.emit('add-flash', { type: 'warning', message: this.messages.fixErrors });

                            this.$nextTick(() => {
                                this.$el.querySelector('.gc-error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            });
                        },

                        handleError(error) {
                            if (
                                error.response?.status === 422
                                && error.response.data.errors
                            ) {
                                this.errors = Object.fromEntries(
                                    Object.entries(error.response.data.errors).map(([field, messages]) => [field, messages[0]])
                                );

                                if (this.errors.occasion) {
                                    this.step = 'occasion';
                                }

                                this.showErrors();

                                return;
                            }

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: error.response?.data?.message || @json(trans('giftcard::app.shop.purchase.payment-failed')),
                            });
                        },
                    },
                });
            </script>
        @endPushOnce
    @endif
</x-shop::layouts>
