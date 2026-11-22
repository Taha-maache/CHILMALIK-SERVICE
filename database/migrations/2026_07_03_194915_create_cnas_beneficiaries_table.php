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
        Schema::create('cnas_beneficiaries', function (Blueprint $table) {
           $table->id();

$table->foreignId('cnas_id')
      ->constrained()
      ->cascadeOnDelete();

$table->string('full_name');

$table->string('cart_pdf')->nullable();

$table->string('birth_pdf')->nullable();

$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnas_beneficiaries');
    }
};
