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
            if (!Schema::hasColumn('shop_carts', 'color_code')) {
                $table->string('color_code')->nullable()->after('color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_carts', function (Blueprint $table) {
            if (Schema::hasColumn('shop_carts', 'color_code')) {
                $table->dropColumn('color_code');
            }
        });
    }
};