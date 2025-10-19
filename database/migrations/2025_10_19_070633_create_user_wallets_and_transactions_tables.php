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
        // Create user_wallets table
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('currency', 3)->default('VND');
            $table->timestamps();

            $table->unique('user_id');
        });

        // Create wallet_transactions table
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('shop_orders')->nullOnDelete();
            $table->enum('type', ['refund', 'withdrawal', 'deposit', 'payment']);
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();
            $table->string('status')->default('completed'); // completed, pending, failed
            $table->json('metadata')->nullable(); // Store PayPal refund ID, etc.
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('user_wallets');
    }
};
