<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('doctor_certificates')) {
            Schema::create('doctor_certificates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
                $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
                $table->string('diagnosis');
                $table->date('date');
                $table->date('leave_from');
                $table->date('leave_to');
                $table->string('certificate_type'); // Corporate / School
                $table->text('doctor_description');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_certificates');
    }
};
