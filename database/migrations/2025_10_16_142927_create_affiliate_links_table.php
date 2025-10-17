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
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_product_id')->constrained('shop_products')->onDelete('cascade');
            $table->string('link_code', 50)->unique();
            $table->string('original_url');
            $table->string('affiliate_url');
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('total_commission', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_clicked_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'shop_product_id']);
            $table->index('link_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_links');
    }
};
