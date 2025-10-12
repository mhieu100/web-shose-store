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
        Schema::table('shop_products', function (Blueprint $table) {
            // Thay đổi cột price từ decimal(10,2) thành decimal(12,2) 
            // để có thể chứa giá tối đa 9,999,999,999.99 VNĐ
            $table->decimal('price', 12, 2)->nullable()->change();
            $table->decimal('old_price', 12, 2)->nullable()->change();
            $table->decimal('cost', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            // Khôi phục lại kiểu dữ liệu cũ
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->decimal('old_price', 10, 2)->nullable()->change();
            $table->decimal('cost', 10, 2)->nullable()->change();
        });
    }
};
