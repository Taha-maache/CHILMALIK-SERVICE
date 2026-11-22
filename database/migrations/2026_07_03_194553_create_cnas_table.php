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
        Schema::create('cnas', function (Blueprint $table) {

    $table->id();

    $table->string('full_name');

    $table->string('NIN')->nullable();

    $table->string('phone')->nullable();

    $table->string('code')->nullable();

    $table->string('mot_de_passe')->nullable();

    $table->string('prove_pdf')->nullable();

    $table->string('rent_pdf')->nullable();

    $table->string('register_pdf')->nullable();

    $table->string('craft_cart_pdf')->nullable();

    $table->string('cart_pdf')->nullable();

    $table->string('birth_certificate_pdf')->nullable();

    $table->string('nif_pdf')->nullable();

    $table->string('chek_barre_pdf')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnas');
    }
};
