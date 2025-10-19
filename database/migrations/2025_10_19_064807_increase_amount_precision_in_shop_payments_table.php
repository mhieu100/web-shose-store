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
            // Change amount from decimal(8,2) to decimal(15,2) to support larger VND amounts
            $table->decimal('amount', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            // Revert back to default decimal(8,2)
            $table->decimal('amount', 8, 2)->change();
        });
    }
};
