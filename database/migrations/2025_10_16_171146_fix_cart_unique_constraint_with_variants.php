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
        Schema::table('shop_carts', function (Blueprint $table) {
            // Add new unique constraint that includes color and size for proper variant handling
            $table->unique(['user_id', 'shop_product_id', 'color', 'size'], 'cart_unique_with_variants');
        });
        
        // Drop the old unique constraint in a separate step (foreign keys don't depend on this specific constraint)
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->dropUnique('shop_carts_user_id_shop_product_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_carts', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique('cart_unique_with_variants');
            
            // Restore the original unique constraint (this may cause data loss if variants exist)
            $table->unique(['user_id', 'shop_product_id'], 'shop_carts_user_id_shop_product_id_unique');
        });
    }
};
