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
    Schema::table('trader_taxes', function (Blueprint $table) {
        $table->string('BP')->nullable();
        $table->string('Nif')->nullable();
        $table->string('structure')->nullable();
        $table->string('number_of_commerce')->nullable();
        $table->date('date_start')->nullable();
        $table->string('place')->nullable();
        $table->string('numero_matiere')->nullable();
        $table->string('adrress_activity')->nullable();
    });
}

public function down()
{
    Schema::table('trader_taxes', function (Blueprint $table) {
        $table->dropColumn(['BP', 'Nif', 'structure', 'number_of_commerce', 'date_start', 'place', 'numero_matiere', 'adrress_activity']);
    });
}};
