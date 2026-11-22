<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxes_payments', function (Blueprint $table) {

            $table->id();

            // Tax parent
            $table->foreignId('tax_id')
                ->constrained('taxes')
                ->cascadeOnDelete();

            // Payment information
            $table->date('payment_date');

            $table->decimal('amount', 15, 2);

            $table->string('reference')->nullable();

            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxes_payments');
    }
};