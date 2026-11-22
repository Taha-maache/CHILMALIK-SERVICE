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
    Schema::create('damancoms', function (Blueprint $table) {
        $table->id();

        $table->string('full_name');
        $table->string('NIN');
        $table->string('phone');
        $table->string('code')->nullable();
        $table->string('mot_de_passe')->nullable();
        $table->string('prove_pdf')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damancoms');
    }
};
