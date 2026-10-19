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
        Schema::table('cart', function (Blueprint $table) {
            $table->string('giftcard_number', 191)->nullable()->after('applied_cart_rule_ids');
            $table->decimal('giftcard_amount', 10, 0)->nullable()->after('giftcard_number');
            $table->decimal('remaining_giftcard_amount', 10, 2)->default(0)->after('giftcard_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn(['giftcard_number', 'giftcard_amount', 'remaining_giftcard_amount']);
        });
    }
};
