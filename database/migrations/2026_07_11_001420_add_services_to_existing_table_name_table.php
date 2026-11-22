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
    Schema::table('services', function (Blueprint $table) {

        $table->boolean('tamdid_salahya')->default(false);
        $table->boolean('istirad')->default(false);
        $table->integer('mosada9a')->nullable();
        $table->boolean('tarjama_register')->default(false);
        $table->boolean('tarjamat_sawabi9')->default(false);
        $table->boolean('talab_c20')->default(false);
        $table->boolean('kachf_hisseb')->default(false);

    });
}

public function down(): void
{
    Schema::table('services', function (Blueprint $table) {

        $table->dropColumn([
            'tamdid_salahya',
            'istirad',
            'mosada9a',
            'tarjama_register',
            'tarjamat_sawabi9',
            'talab_c20',
            'kachf_hisseb'
        ]);

    });
}
};
