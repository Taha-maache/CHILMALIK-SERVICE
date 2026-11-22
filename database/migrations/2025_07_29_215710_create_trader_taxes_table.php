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
        Schema::create('trader_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->constrained('traders')->onDelete('cascade');
            $table->enum('tax_type', ['G12'])->nullable();
            $table->integer('tax_year')->default(2025);
            $table->enum('tax_value', ['12', '5', '0.5']);
            $table->decimal('revenue')->nullable();
            $table->decimal('valeur_tax_IFU')->nullable();
            $table->enum('pay_type', ['total', 'credit'])->nullable()->default('total');
            $table->decimal('pay_total')->nullable();
            $table->date('date_pay')->nullable();
            $table->decimal('pay_tranche1')->nullable();
            $table->date('date_tranche1')->nullable();
            $table->decimal('pay_tranche2')->nullable();
            $table->date('date_tranche2')->nullable();
            $table->decimal('pay_tranche3')->nullable();
            $table->date('date_tranche3')->nullable();
            $table->text('notes')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('receipt1_number')->nullable();
            $table->string('receipt2_number')->nullable();
            $table->string('receipt3_number')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trader_taxes');
    }
};
