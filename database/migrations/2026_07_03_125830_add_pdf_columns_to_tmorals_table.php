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
    Schema::table('tmorals', function (Blueprint $table) {
        $table->string('naming_pdf')->nullable();
        $table->string('rent_pdf')->nullable();
        $table->string('essential_law_pdf')->nullable();
        $table->string('Boal_pdf')->nullable();
        $table->string('fiche_navet_pdf')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
 public function down(): void
{
    Schema::table('tmorals', function (Blueprint $table) {
        $table->dropColumn([
            'naming_pdf',
            'rent_pdf',
            'essential_law_pdf',
            'Boal_pdf',
            'fiche_navet_pdf',
        ]);
    });
}

};
