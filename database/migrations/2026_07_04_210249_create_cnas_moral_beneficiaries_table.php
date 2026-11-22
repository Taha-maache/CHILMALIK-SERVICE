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
     Schema::create('cnas_moral_beneficiaries', function (Blueprint $table) {

    $table->id();

    $table->foreignId('cnas_moral_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('full_name')->nullable();

    $table->string('cart_pdf')->nullable();

    $table->string('photo_pdf')->nullable();

    $table->string('residence_pdf')->nullable();

    $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnas_moral_beneficiaries');
    }
};
