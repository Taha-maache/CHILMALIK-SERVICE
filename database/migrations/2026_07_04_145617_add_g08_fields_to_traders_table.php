<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('traders', function (Blueprint $table) {

            $table->string('nif')->nullable();

            $table->string('number_of_register')->nullable();

            $table->string('cpi')->nullable();

            $table->string('activity_address_g08')->nullable();

            $table->date('starting_date')->nullable();

            

        });
    }

    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {

            $table->dropColumn([
                'nif',
                'number_of_register',
                'cpi',
                'activity_address_g08',
                'starting_date',
                
            ]);

        });
    }
};