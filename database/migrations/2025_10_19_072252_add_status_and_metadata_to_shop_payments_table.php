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
        Schema::table('shop_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_payments', 'status')) {
                $table->string('status')->default('pending')->after('currency');
            }
            if (!Schema::hasColumn('shop_payments', 'metadata')) {
                $table->json('metadata')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('shop_payments', 'status')) {
                $columns[] = 'status';
            }
            if (Schema::hasColumn('shop_payments', 'metadata')) {
                $columns[] = 'metadata';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
