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
        // Ensure required variant columns exist before applying a unique constraint on them
        Schema::table('shop_carts', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_carts', 'color')) {
                $table->string('color')->nullable()->after('price');
            }
            if (!Schema::hasColumn('shop_carts', 'color_code')) {
                $table->string('color_code')->nullable()->after('color');
            }
            if (!Schema::hasColumn('shop_carts', 'size')) {
                $table->string('size')->nullable()->after('color_code');
            }

            // Ensure there are individual indexes to satisfy foreign keys before dropping the composite unique
            $table->index('shop_product_id', 'shop_carts_shop_product_id_index');
            $table->index('user_id', 'shop_carts_user_id_index');
        });

        // Drop the old unique constraint first to avoid conflicts
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->dropUnique('shop_carts_user_id_shop_product_id_unique');
        });

        // Add new unique constraint that includes color and size for proper variant handling
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->unique(['user_id', 'shop_product_id', 'color', 'size'], 'cart_unique_with_variants');
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

            // Optionally drop the added columns to revert schema (keep if data should be preserved)
            if (Schema::hasColumn('shop_carts', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('shop_carts', 'color_code')) {
                $table->dropColumn('color_code');
            }
            if (Schema::hasColumn('shop_carts', 'color')) {
                $table->dropColumn('color');
            }
        });
    }
};
