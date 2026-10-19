<x-shop::layouts>
    <x-slot:title>
        @lang('giftcard::app.shop.purchase.title')
    </x-slot>

    <div class="gc-shell">
        <section class="gc-hero">
            <div class="gc-hero-text">
                <h1 class="gc-hero-title">
                    @lang('giftcard::app.shop.purchase.title')
                </h1>

                <p class="gc-hero-lead">
                    @lang('giftcard::app.shop.purchase.description')
                </p>

                <ul class="gc-features">
                    <li>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v12H4z" /><path d="m4 7 8 6 8-6" /></svg>

                        @lang('giftcard::app.shop.purchase.feature-email')
                    </li>

                    <li>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8" /><path d="M12 8v4l3 2" /></svg>

                        @lang('giftcard::app.shop.purchase.feature-validity', ['days' => $settings['validity_days']])
                    </li>

                    <li>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 7h14l-1.5 9h-11z" /><circle cx="9" cy="19" r="1" /><circle cx="16" cy="19" r="1" /><path d="M5 7 4 4H2" /></svg>

                        @lang('giftcard::app.shop.purchase.feature-redeem')
                    </li>
                </ul>
            </div>

            <div
                class="gc-hero-art"
                aria-hidden="true"
            >
                @foreach (collect($occasions)->whereIn('key', ['birthday', 'diwali', 'holi'])->values() as $sample)
                    <img
                        class="gc-hero-card gc-hero-card-{{ $loop->index }}"
                        src="{{ $sample['image'] }}"
                        alt=""
                    >
                @endforeach
            </div>
        </section>

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
                <div class="gc-flow">
                    <ol class="gc-steps">
                        <li
                            class="gc-step"
                            :class="stepClass(index)"
                            v-for="(label, index) in stepLabels"
                            :key="index"
                        >
                            <button
                                type="button"
                                class="gc-step-button"
                                :disabled="index !== 0 || step === 'occasion'"
                                @click="step = 'occasion'"
                            >
                                <span class="gc-step-number">@{{ index + 1 }}</span>

                                <span class="gc-step-label">@{{ label }}</span>
                            </button>
                        </li>
                    </ol>

                    <section
                        class="gc-panel"
                        v-show="step === 'occasion'"
                    >
                        <div class="gc-panel-head">
                            <h2 class="gc-heading">
                                @lang('giftcard::app.shop.purchase.choose-occasion')
                            </h2>

                            <div
                                class="gc-chips"
                                role="tablist"
                            >
                                <button
                                    type="button"
                                    class="gc-chip"
                                    role="tab"
                                    :class="{ 'gc-chip-active': filter === key }"
                                    :aria-selected="filter === key"
                                    v-for="(label, key) in filters"
                                    :key="key"
                                    @click="filter = key"
                                >
                                    @{{ label }}
                                </button>
                            </div>
                        </div>

                        <div class="gc-tiles">
                            <button
                                type="button"
                                class="gc-tile"
                                :class="{ 'gc-tile-selected': form.occasion === occasion.key }"
                                v-for="occasion in visibleOccasions"
                                :key="occasion.key"
                                :aria-pressed="form.occasion === occasion.key"
                                @click="selectOccasion(occasion)"
                            >
                                <span class="gc-tile-image">
                                    <img
                                        :src="occasion.image"
                                        :alt="occasion.name"
                                        loading="lazy"
                                    >

                                    <span
                                        class="gc-tile-check"
                                        v-if="form.occasion === occasion.key"
                                    >
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 5 5 9-10" /></svg>
                                    </span>
                                </span>

                                <span class="gc-tile-name">@{{ occasion.name }}</span>
                            </button>
                        </div>

                        <p
                            class="gc-error"
                            v-if="errors.occasion"
                        >
                            @{{ errors.occasion }}
                        </p>
                    </section>

                    <div
                        class="gc-details"
                        v-if="step === 'details'"
                    >
                        <aside class="gc-preview-col">
                            <div class="gc-card">
                                <div class="gc-card-art">
                                    <img
                                        :src="selectedOccasion.image"
                                        :alt="selectedOccasion.name"
                                    >

                                    <span class="gc-card-amount">@{{ formattedAmount }}</span>
                                </div>

                                <div class="gc-card-body">
                                    <p class="gc-card-greeting">@{{ selectedOccasion.greeting }}</p>

                                    <div class="gc-card-people">
                                        <div>
                                            <span class="gc-card-label">@lang('giftcard::app.shop.purchase.to')</span>

                                            <span class="gc-card-value">@{{ form.recipient_name || '—' }}</span>
                                        </div>

                                        <div>
                                            <span class="gc-card-label">@lang('giftcard::app.shop.purchase.from')</span>

                                            <span class="gc-card-value">@{{ form.sender_name || '—' }}</span>
                                        </div>
                                    </div>

                                    <p
                                        class="gc-card-message"
                                        v-if="form.message"
                                    >
                                        “@{{ form.message }}”
                                    </p>

                                    <div class="gc-card-footer">
                                        <span class="gc-card-code">@lang('giftcard::app.shop.purchase.sample-code')</span>

                                        <span class="gc-card-store">{{ core()->getCurrentChannel()->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="gc-link gc-change"
                                @click="step = 'occasion'"
                            >
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6 9 12l6 6" /></svg>

                                @lang('giftcard::app.shop.purchase.change-occasion')
                            </button>
                        </aside>

                        <div class="gc-form-col">
                            <section class="gc-panel">
                                <h2 class="gc-section-title">
                                    @lang('giftcard::app.shop.purchase.amount', ['currency' => $settings['currency']])
                                </h2>

                                <div class="gc-amounts">
                                    <button
                                        type="button"
                                        class="gc-amount"
                                        :class="{ 'gc-amount-selected': Number(form.amount) === preset }"
                                        v-for="preset in presets"
                                        :key="preset"
                                        @click="form.amount = preset"
                                    >
                                        @{{ formatMoney(preset) }}
                                    </button>
                                </div>

                                <label
                                    class="gc-label"
                                    for="gc-amount"
                                >
                                    @lang('giftcard::app.shop.purchase.custom-amount')
                                </label>

                                <div
                                    class="gc-input-group"
                                    :class="{ 'gc-input-invalid': errors.amount }"
                                >
                                    <span class="gc-input-prefix">{{ $settings['currency'] }}</span>

                                    <input
                                        id="gc-amount"
                                        type="number"
                                        class="gc-input"
                                        v-model="form.amount"
                                        :min="settings.min_amount"
                                        :max="settings.max_amount"
                                        step="0.01"
                                    >
                                </div>

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
                            </section>

                            <section
                                class="gc-panel"
                                v-for="group in fieldGroups"
                                :key="group.title"
                            >
                                <h2 class="gc-section-title">@{{ group.title }}</h2>

                                <div class="gc-field-grid">
                                    <div
                                        class="gc-field"
                                        :class="{ 'gc-field-wide': field.type === 'textarea' }"
                                        v-for="field in group.fields"
                                        :key="field.name"
                                    >
                                        <label
                                            class="gc-label"
                                            :class="{ required: field.required }"
                                            :for="'gc-' + field.name"
                                        >
                                            @{{ field.label }}
                                        </label>

                                        <template v-if="field.type === 'textarea'">
                                            <textarea
                                                class="gc-input"
                                                rows="4"
                                                maxlength="500"
                                                :id="'gc-' + field.name"
                                                :class="{ 'gc-input-invalid': errors[field.name] }"
                                                :placeholder="messages.messagePlaceholder"
                                                v-model="form[field.name]"
                                            ></textarea>

                                            <p class="gc-counter">@{{ (form[field.name] || '').length }} / 500</p>
                                        </template>

                                        <input
                                            class="gc-input"
                                            maxlength="255"
                                            :type="field.type"
                                            :id="'gc-' + field.name"
                                            :class="{ 'gc-input-invalid': errors[field.name] }"
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
                                </div>
                            </section>

                            <section class="gc-panel">
                                <h2 class="gc-section-title">
                                    @lang('giftcard::app.shop.purchase.summary')
                                </h2>

                                <div class="gc-summary">
                                    <div class="gc-summary-row">
                                        <span>@lang('giftcard::app.shop.purchase.card-value')</span>

                                        <span>@{{ formattedAmount }}</span>
                                    </div>

                                    <div class="gc-summary-row gc-summary-total">
                                        <span>@lang('giftcard::app.shop.purchase.total')</span>

                                        <span>@{{ formattedAmount }}</span>
                                    </div>
                                </div>

                                <div
                                    class="gc-paypal"
                                    ref="paypalContainer"
                                ></div>

                                <p class="gc-secure">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="11" width="14" height="9" rx="2" /><path d="M8 11V8a4 4 0 0 1 8 0v3" /></svg>

                                    @lang('giftcard::app.shop.purchase.secure-note')
                                </p>
                            </section>
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

                            filter: 'all',

                            settings: @json($settings),

                            occasions: @json($occasions),

                            selectedOccasion: null,

                            errors: {},

                            stepLabels: [
                                @json(trans('giftcard::app.shop.purchase.step-occasion')),
                                @json(trans('giftcard::app.shop.purchase.step-details')),
                            ],

                            filters: {
                                all: @json(trans('giftcard::app.shop.purchase.filter-all')),
                                festivals: @json(trans('giftcard::app.shop.purchase.filter-festivals')),
                                celebrations: @json(trans('giftcard::app.shop.purchase.filter-celebrations')),
                                family: @json(trans('giftcard::app.shop.purchase.filter-family')),
                            },

                            messages: {
                                required: @json(trans('giftcard::app.shop.purchase.required')),
                                invalidEmail: @json(trans('giftcard::app.shop.purchase.invalid-email')),
                                fixErrors: @json(trans('giftcard::app.shop.purchase.fix-errors')),
                                messagePlaceholder: @json(trans('giftcard::app.shop.purchase.message-placeholder')),
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

                            fieldGroups: [
                                {
                                    title: @json(trans('giftcard::app.shop.purchase.recipient')),
                                    fields: [
                                        { name: 'recipient_name', type: 'text', required: true, label: @json(trans('giftcard::app.shop.purchase.recipient-name')) },
                                        { name: 'recipient_email', type: 'email', required: true, label: @json(trans('giftcard::app.shop.purchase.recipient-email')) },
                                        { name: 'message', type: 'textarea', required: false, label: @json(trans('giftcard::app.shop.purchase.message')) },
                                    ],
                                },
                                {
                                    title: @json(trans('giftcard::app.shop.purchase.sender')),
                                    fields: [
                                        { name: 'sender_name', type: 'text', required: true, label: @json(trans('giftcard::app.shop.purchase.sender-name')) },
                                        { name: 'sender_email', type: 'email', required: true, label: @json(trans('giftcard::app.shop.purchase.sender-email')) },
                                    ],
                                },
                            ],
                        };
                    },

                    computed: {
                        fields() {
                            return this.fieldGroups.flatMap((group) => group.fields);
                        },

                        visibleOccasions() {
                            if (this.filter === 'all') {
                                return this.occasions;
                            }

                            return this.occasions.filter((occasion) => occasion.group === this.filter);
                        },

                        presets() {
                            return this.settings.preset_amounts.filter((amount) => {
                                return amount >= this.settings.min_amount
                                    && amount <= this.settings.max_amount;
                            });
                        },

                        formattedAmount() {
                            return this.formatMoney(Number(this.form.amount) || 0);
                        },
                    },

                    methods: {
                        stepClass(index) {
                            let current = this.step === 'occasion' ? 0 : 1;

                            return {
                                'gc-step-active': index === current,
                                'gc-step-done': index < current,
                            };
                        },

                        formatMoney(amount) {
                            return new Intl.NumberFormat(document.documentElement.lang || 'en', {
                                style: 'currency',
                                currency: this.settings.currency,
                            }).format(amount);
                        },

                        selectOccasion(occasion) {
                            this.selectedOccasion = occasion;

                            this.form.occasion = occasion.key;

                            this.errors = {};

                            this.step = 'details';

                            this.$nextTick(() => {
                                this.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });

                                this.renderPaypalButtons();
                            });
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
                                    shape: 'pill',
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
