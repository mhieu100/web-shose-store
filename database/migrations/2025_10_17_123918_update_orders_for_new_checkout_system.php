<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            // Add columns only if they don't exist
            if (!Schema::hasColumn('shop_orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('shop_orders', 'order_number')) {
                $table->string('order_number', 50)->nullable()->after('number');
            }

            if (!Schema::hasColumn('shop_orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->nullable()->after('total_price');
            }

            if (!Schema::hasColumn('shop_orders', 'tax_amount')) {
                $table->decimal('tax_amount', 12, 2)->default(0)->after('subtotal');
            }

            if (!Schema::hasColumn('shop_orders', 'shipping_amount')) {
                $table->decimal('shipping_amount', 12, 2)->default(0)->after('tax_amount');
            }

            if (!Schema::hasColumn('shop_orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('shipping_amount');
            }

            if (!Schema::hasColumn('shop_orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->nullable()->after('discount_amount');
            }

            if (!Schema::hasColumn('shop_orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('currency');
            }

            if (!Schema::hasColumn('shop_orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])
                      ->default('pending')->after('payment_method');
            }

            if (!Schema::hasColumn('shop_orders', 'billing_address')) {
                $table->json('billing_address')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('shop_orders', 'shipping_address')) {
                $table->json('shipping_address')->nullable()->after('billing_address');
            }

            if (!Schema::hasColumn('shop_orders', 'coupon_code')) {
                $table->string('coupon_code', 100)->nullable()->after('shipping_address');
            }

            if (!Schema::hasColumn('shop_orders', 'coupon_discount')) {
                $table->decimal('coupon_discount', 12, 2)->default(0)->after('coupon_code');
            }

            if (!Schema::hasColumn('shop_orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('coupon_discount');
            }

            if (!Schema::hasColumn('shop_orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }

            if (!Schema::hasColumn('shop_orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            }
        });

        // Update existing data safely - ensure no empty or duplicate order_numbers
        DB::statement("UPDATE shop_orders SET order_number = CONCAT('ORD-', DATE_FORMAT(created_at, '%Y%m%d'), '-', LPAD(id, 6, '0')) WHERE order_number IS NULL OR order_number = ''");
        DB::statement("UPDATE shop_orders SET subtotal = COALESCE(total_price, 0) WHERE subtotal IS NULL");
        DB::statement("UPDATE shop_orders SET total_amount = COALESCE(total_price, 0) WHERE total_amount IS NULL");
        DB::statement("UPDATE shop_orders SET payment_method = 'cod' WHERE payment_method IS NULL OR payment_method = ''");

        // Add unique constraint if it doesn't exist
        $indexes = DB::select("SHOW INDEX FROM shop_orders WHERE Key_name = 'shop_orders_order_number_unique'");
        if (empty($indexes)) {
            Schema::table('shop_orders', function (Blueprint $table) {
                $table->unique('order_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            // Drop columns if they exist
            $columnsToCheck = [
                'user_id', 'order_number', 'subtotal', 'tax_amount', 'shipping_amount',
                'discount_amount', 'total_amount', 'payment_method', 'payment_status',
                'billing_address', 'shipping_address', 'coupon_code', 'coupon_discount',
                'shipped_at', 'delivered_at', 'cancelled_at'
            ];

            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('shop_orders', $column)) {
                    if ($column === 'user_id') {
                        $table->dropForeign(['user_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};
