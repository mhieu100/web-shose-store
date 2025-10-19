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
        Schema::create('wallet_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['paypal', 'bank_transfer']);
            $table->enum('status', ['pending', 'pending_verification', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('transaction_reference')->nullable();
            $table->string('transfer_proof')->nullable(); // File path for bank transfer proof
            $table->json('payment_data')->nullable(); // Store PayPal payment data
            $table->timestamp('submitted_at')->nullable(); // When user submitted bank transfer info
            $table->timestamp('verified_at')->nullable(); // When admin verified
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_deposits');
    }
};
