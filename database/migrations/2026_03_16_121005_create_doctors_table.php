<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
Schema::create('doctors', function (Blueprint $table) {

$table->id();

$table->string('name');
$table->string('aadhar');
$table->string('license_no');

$table->string('specialization');
$table->string('phone');

$table->integer('experience');
$table->text('clinic_address')->nullable();

$table->string('photo')->nullable();

$table->timestamps();

});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
