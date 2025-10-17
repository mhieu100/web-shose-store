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
        Schema::table('users', function (Blueprint $table) {
            $table->string('affiliate_code', 20)->unique()->nullable()->after('role_id');
            $table->decimal('commission_rate', 5, 2)->default(5.00)->after('affiliate_code');
            $table->boolean('is_affiliate_active')->default(false)->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['affiliate_code', 'commission_rate', 'is_affiliate_active']);
        });
    }
};
