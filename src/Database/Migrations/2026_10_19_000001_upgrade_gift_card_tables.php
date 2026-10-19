<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->decimal('giftcard_amount', 12, 4)->change();
            $table->string('expirein', 190)->nullable()->change();
            $table->string('sendername', 191)->nullable()->change();
            $table->string('senderemail', 255)->nullable()->change();
            $table->string('recipientname', 255)->nullable()->change();
            $table->string('recipientemail', 255)->nullable()->change();
            $table->string('message', 500)->nullable()->change();
            $table->string('occasion', 100)->nullable()->after('message');
        });

        if (! Schema::hasIndex('gift_cards', ['giftcard_number'], 'unique')) {
            Schema::table('gift_cards', function (Blueprint $table) {
                $table->unique('giftcard_number');
            });
        }

        Schema::table('gift_card_balances', function (Blueprint $table) {
            $table->decimal('giftcard_amount', 12, 4)->change();
            $table->decimal('used_giftcard_amount', 12, 4)->default(0)->change();
            $table->decimal('remaining_giftcard_amount', 12, 4)->default(0)->change();
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->decimal('giftcard_amount', 12, 4)->nullable()->change();
            $table->decimal('base_giftcard_amount', 12, 4)->nullable()->after('giftcard_amount');
            $table->decimal('remaining_giftcard_amount', 12, 4)->default(0)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('base_giftcard_amount', 12, 4)->nullable()->after('giftcard_amount');
            $table->decimal('base_giftcard_amount_canceled', 12, 4)->default(0)->after('base_giftcard_amount');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('base_giftcard_amount', 12, 4)->nullable()->after('giftcard_amount');
        });

        Schema::table('refunds', function (Blueprint $table) {
            $table->decimal('giftcard_amount', 12, 4)->nullable()->after('grand_total');
            $table->decimal('base_giftcard_amount', 12, 4)->nullable()->after('giftcard_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropColumn(['giftcard_amount', 'base_giftcard_amount']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('base_giftcard_amount');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['base_giftcard_amount', 'base_giftcard_amount_canceled']);
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('base_giftcard_amount');
        });

        Schema::table('gift_cards', function (Blueprint $table) {
            $table->dropColumn('occasion');
        });
    }
};
