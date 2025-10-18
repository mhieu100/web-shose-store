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
        Schema::table('shop_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_orders', 'affiliate_user_id')) {
                $table->foreignId('affiliate_user_id')->nullable()->constrained('users')->onDelete('set null')->after('shop_customer_id');
            }
            if (!Schema::hasColumn('shop_orders', 'affiliate_code')) {
                $table->string('affiliate_code', 20)->nullable()->after('affiliate_user_id');
            }
            if (!Schema::hasColumn('shop_orders', 'affiliate_link_code')) {
                $table->string('affiliate_link_code', 50)->nullable()->after('affiliate_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('affiliate_user_id');
            $table->dropColumn(['affiliate_code', 'affiliate_link_code']);
        });
    }
};
