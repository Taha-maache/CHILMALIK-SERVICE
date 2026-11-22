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
        Schema::table('taxes', function (Blueprint $table) {
     $table->string('nif_pdf')->nullable();
$table->string('nis_pdf')->nullable();
$table->string('g8_pdf')->nullable();
$table->string('g12_pdf')->nullable();
$table->string('g12bis_pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taxes', function (Blueprint $table) {
            //
        });
    }
};
