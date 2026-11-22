<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisans', function (Blueprint $table) {

            $table->id();

            $table->string('full_name');

            $table->string('NIN')->nullable();

            $table->string('phone')->nullable();

            $table->string('number_of_registration')->nullable();

            $table->string('number_of_casnos')->nullable();

            $table->enum('etat', [
                'transfere_au_char',
                'recuperer_du_char',
                'livrer_au_client',
            ])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};