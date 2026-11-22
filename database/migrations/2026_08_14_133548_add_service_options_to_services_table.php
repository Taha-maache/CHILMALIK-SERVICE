<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {

            $table->boolean('creation_CA')->default(0);
            $table->boolean('creation_dplm_CA')->default(0);
            $table->boolean('annulation_CA')->default(0);
            $table->boolean('efficacite')->default(0);
            $table->boolean('tasmya')->default(0);
            $table->boolean('tarjamat_boal')->default(0);
            $table->boolean('ichhar_boal')->default(0);
            $table->boolean('creation_entreprise')->default(0);
            $table->boolean('chahedat_ihtiram')->default(0);
            $table->boolean('nif_alces')->default(0);
            $table->boolean('nif_dowan')->default(0);
            $table->boolean('g50')->default(0);
            $table->boolean('irg_salaire')->default(0);
            $table->boolean('tva')->default(0);
            $table->boolean('khidma_ijer_mahal')->default(0);
            $table->boolean('ta3dil_CA')->default(0);

            // مثال: 2024
            $table->year('anne_de_modification')->nullable();

            // القيم: 1 أو 2
            $table->tinyInteger('number_of_galization')
                ->nullable()
                ->unsigned();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {

            $table->dropColumn([
                'creation_CA',
                'creation_dplm_CA',
                'annulation_CA',
                'efficacite',
                'tasmya',
                'tarjamat_boal',
                'ichhar_boal',
                'creation_entreprise',
                'chahedat_ihtiram',
                'nif_alces',
                'nif_dowan',
                'g50',
                'irg_salaire',
                'tva',
                'khidma_ijer_mahal',
                'ta3dil_CA',
                'anne_de_modification',
                'number_of_galization',
                
            ]);
        });
    }
};