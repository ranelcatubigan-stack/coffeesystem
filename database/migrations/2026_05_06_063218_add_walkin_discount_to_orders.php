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
    Schema::table('orders', function (Blueprint $table) {
        $table->boolean('is_walkin')->default(false)->after('user_id');
        $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        if (Schema::hasColumn('orders', 'is_walkin')) {
            $table->dropColumn('is_walkin');
        }
        if (Schema::hasColumn('orders', 'discount_amount')) {
            $table->dropColumn('discount_amount');
        }
    });
}
};
