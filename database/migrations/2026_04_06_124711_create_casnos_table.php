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
    Schema::create('casnos', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom');
        $table->string('matricule')->unique();
        $table->string('pay_type'); // هنا دير فيه كامل ولا دين
        $table->date('date_paiement')->nullable(); // هادي لي قتلي عليها في حالة "دين"
        $table->decimal('montant_versse', 15, 2)->default(0);
        $table->decimal('montant_enkissi', 15, 2)->default(0);
        $table->decimal('montant_rest', 15, 2)->virtualAs('montant_versse - montant_enkissi'); // يتحسب أوتوماتيكيا في MySQL
        $table->string('phone')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casnos');
    }
};
