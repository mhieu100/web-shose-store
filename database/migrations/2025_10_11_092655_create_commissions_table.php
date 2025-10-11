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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // CTV
            $table->foreignId('order_id')->constrained('shop_orders')->onDelete('cascade'); // Đơn hàng
            $table->foreignId('product_id')->nullable()->constrained('shop_products')->onDelete('set null'); // Sản phẩm
            $table->decimal('order_amount', 15, 2); // Giá trị đơn hàng
            $table->decimal('commission_rate', 5, 2); // % hoa hồng (VD: 15.50 = 15.5%)
            $table->decimal('commission_amount', 15, 2); // Số tiền hoa hồng
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->text('notes')->nullable(); // Ghi chú
            $table->timestamp('approved_at')->nullable(); // Ngày duyệt
            $table->timestamp('paid_at')->nullable(); // Ngày thanh toán
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['order_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
