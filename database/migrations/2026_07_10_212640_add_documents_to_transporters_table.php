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
    Schema::table('transporters', function (Blueprint $table) {

        $table->string('register_pdf')->nullable();
        $table->string('scanner_pdf')->nullable();
        $table->string('carte_grise_pdf')->nullable();
        $table->string('mou9arar_na9l_pdf')->nullable();
        $table->string('kafaa_pdf')->nullable();
        $table->string('permit_pdf')->nullable();
        $table->string('permit_cerculer_pdf')->nullable();
        $table->string('casnos_pdf')->nullable();
        $table->string('nif_pdf')->nullable();

    });
}

public function down(): void
{
    Schema::table('transporters', function (Blueprint $table) {

        $table->dropColumn([
            'register_pdf',
            'scanner_pdf',
            'carte_grise_pdf',
            'mou9arar_na9l_pdf',
            'kafaa_pdf',
            'permit_pdf',
            'permit_cerculer_pdf',
            'casnos_pdf',
            'nif_pdf',
        ]);

    });
}

};
