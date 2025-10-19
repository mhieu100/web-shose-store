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
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->after('provider');
            $table->json('response_data')->nullable()->after('provider_id');
            $table->timestamp('paid_at')->nullable()->after('response_data');
            $table->string('status')->default('pending')->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->dropColumn(['provider_id', 'response_data', 'paid_at', 'status']);
        });
    }
};