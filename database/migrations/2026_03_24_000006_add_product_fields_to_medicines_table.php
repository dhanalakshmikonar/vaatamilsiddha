<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('mode_of_product')->nullable()->after('name');
            $table->string('pharmaceutical_name')->nullable()->after('mode_of_product');
            $table->date('expiry_date')->nullable()->after('pharmaceutical_name');
            $table->decimal('cost_price', 10, 2)->default(0)->after('expiry_date');
            $table->decimal('selling_price', 10, 2)->default(0)->after('cost_price');
            $table->decimal('total_amount', 12, 2)->default(0)->after('selling_price');
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'mode_of_product',
                'pharmaceutical_name',
                'expiry_date',
                'cost_price',
                'selling_price',
                'total_amount',
            ]);
        });
    }
};
