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
        Schema::create('commission_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_code')->unique(); // Mã yêu cầu rút tiền
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // CTV yêu cầu rút
            $table->decimal('amount', 15, 2); // Số tiền yêu cầu rút
            $table->decimal('fee', 15, 2)->default(0); // Phí rút tiền
            $table->decimal('net_amount', 15, 2); // Số tiền thực nhận (amount - fee)
            $table->enum('status', ['pending', 'approved', 'processing', 'completed', 'rejected'])->default('pending');
            $table->enum('payment_method', ['bank_transfer', 'e_wallet', 'cash'])->default('bank_transfer');
            $table->json('payment_info'); // Thông tin thanh toán (số TK, tên ngân hàng...)
            $table->text('reason')->nullable(); // Lý do từ chối (nếu có)
            $table->text('admin_notes')->nullable(); // Ghi chú của admin
            $table->timestamp('requested_at'); // Ngày yêu cầu
            $table->timestamp('approved_at')->nullable(); // Ngày duyệt
            $table->timestamp('completed_at')->nullable(); // Ngày hoàn thành
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // Admin duyệt
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['status', 'requested_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_withdrawals');
    }
};
