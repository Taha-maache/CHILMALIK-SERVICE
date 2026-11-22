<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('casnos_payments', function (Blueprint $table) {
        $table->id();

        // relation (اختياري nullable)
        $table->foreignId('trader_id')->nullable()->constrained()->nullOnDelete();

        $table->date('date_paiement');
        $table->string('matricule');
        $table->string('pay_type');

        $table->decimal('montant_versse', 10, 2);
        $table->decimal('montant_enkissi', 10, 2);

        $table->string('username')->nullable();
        $table->string('password')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
 public function down()
{
    Schema::dropIfExists('casnos_payments');
}
};
