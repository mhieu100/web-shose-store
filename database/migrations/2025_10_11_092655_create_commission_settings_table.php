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
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'global', 'category', 'product', 'user'
            $table->foreignId('target_id')->nullable(); // ID của category/product/user
            $table->string('target_type')->nullable(); // App\Models\Shop\Category, App\Models\Shop\Product, App\Models\User
            $table->decimal('commission_rate', 5, 2); // % hoa hồng
            $table->decimal('min_order_amount', 15, 2)->default(0); // Đơn hàng tối thiểu
            $table->decimal('max_commission', 15, 2)->nullable(); // Hoa hồng tối đa
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0); // Độ ưu tiên (số càng cao càng ưu tiên)
            $table->timestamp('valid_from')->nullable(); // Có hiệu lực từ
            $table->timestamp('valid_until')->nullable(); // Có hiệu lực đến
            $table->text('description')->nullable(); // Mô tả
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index(['target_type', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_settings');
    }
};
