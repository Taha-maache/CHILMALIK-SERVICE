<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casnos_payment_transactions', function (Blueprint $table) {

            $table->id();

            // Client from casnos_payments
            $table->unsignedBigInteger('casnos_payment_id');

            // Payment information
            $table->decimal('amount', 12, 2);

            $table->date('payment_date');

            // Additional information
            $table->string('reference')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            // Relation
            $table->foreign('casnos_payment_id')
                  ->references('id')
                  ->on('casnos_payments')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casnos_payment_transactions');
    }
};