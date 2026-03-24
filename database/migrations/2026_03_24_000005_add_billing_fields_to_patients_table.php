<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('place')->nullable()->after('phone');
            $table->string('entity')->nullable()->after('place');
            $table->string('payment_mode')->nullable()->after('entity');
            $table->decimal('fees', 10, 2)->default(0)->after('payment_mode');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['place', 'entity', 'payment_mode', 'fees']);
        });
    }
};
