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
Schema::create('cnas_morals', function (Blueprint $table) {

    $table->id();

    $table->string('label_name')->nullable();

    $table->string('NIN')->nullable();

    $table->string('phone')->nullable();

    $table->string('code')->nullable();

    $table->string('mot_de_passe')->nullable();

    $table->string('prove_pdf')->nullable();

    $table->string('rent_pdf')->nullable();

    $table->string('G08_pdf')->nullable();

    $table->string('register_pdf')->nullable();

    $table->string('cart_pdf')->nullable();

    $table->string('residence_pdf')->nullable();

    $table->string('Boal_pdf')->nullable();

    $table->string('rential_law_pdf')->nullable();

    $table->string('Nif_pdf')->nullable();

    $table->string('chek_baree_pdf')->nullable();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnas_morals');
    }
};
