<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'commission' to the existing enum type
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('refund', 'withdrawal', 'deposit', 'payment', 'commission')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'commission' from the enum type
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('refund', 'withdrawal', 'deposit', 'payment')");
    }
};
