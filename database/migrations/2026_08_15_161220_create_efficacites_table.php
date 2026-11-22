<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('efficacites', function (Blueprint $table) {

            $table->id();

            $table->string('full_name');

            $table->string('phone')->nullable();

            $table->date('date_Paiment_fichier')->nullable();

            $table->enum('etat', [
                'transferer_au_ecole',
                'recuperer_du_ecole',
                'livrer_au_client',
            ])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('efficacites');
    }
};