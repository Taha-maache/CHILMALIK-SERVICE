<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trader_tax_payments', function (Blueprint $table) {

            $table->id();

            // Tax concerné
            $table->foreignId('trader_tax_id')
                ->constrained('trader_taxes')
                ->cascadeOnDelete();

            // Date du paiement
            $table->date('payment_date');

            // Montant payé
            $table->decimal('amount', 15, 2);

            // Référence du paiement
            $table->string('reference')->nullable();

            // Description
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trader_tax_payments');
    }
};