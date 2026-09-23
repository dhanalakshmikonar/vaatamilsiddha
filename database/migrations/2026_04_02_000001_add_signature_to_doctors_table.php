<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('doctors') && !Schema::hasColumn('doctors', 'signature')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('signature')->nullable()->after('aadhar_photo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('doctors') && Schema::hasColumn('doctors', 'signature')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('signature');
            });
        }
    }
};
