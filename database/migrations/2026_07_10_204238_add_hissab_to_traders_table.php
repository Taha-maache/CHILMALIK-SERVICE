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
    Schema::table('traders', function (Blueprint $table) {

        $table->string('hissab')->nullable();
        $table->integer('number_of_codes')
              ->default(0)
 ;
    });
}

public function down(): void
{
    Schema::table('traders', function (Blueprint $table) {

        $table->dropColumn([
            'hissab',
            'number_of_codes'
        ]);

    });
}
};
