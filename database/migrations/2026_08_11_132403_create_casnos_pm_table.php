<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casnos_pm', function (Blueprint $table) {
            $table->id();

            // Client CASNOS
            $table->foreignId('casnos_id')
                  ->constrained('casnos')
                  ->cascadeOnDelete();

            // Informations paiement
            $table->date('date_paiement');

            $table->string('matricule')->nullable();


            $table->decimal('montant_versse', 10, 2)->default(0);

            $table->decimal('montant_enkissi', 10, 2)->default(0);

            // Référence du paiement
            $table->string('reference')->nullable();

            // Informations utilisateur

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casnos_pm');
    }
};