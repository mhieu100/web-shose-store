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
            $table->json('sizes')->nullable()->after('description'); // Lưu trữ các size dưới dạng JSON
            $table->json('colors')->nullable()->after('sizes'); // Lưu trữ các màu dưới dạng JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropColumn(['sizes', 'colors']);
        });
    }
};
