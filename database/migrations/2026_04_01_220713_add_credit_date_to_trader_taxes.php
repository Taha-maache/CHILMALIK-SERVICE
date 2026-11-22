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
        $table->date('credit_date')->nullable(); // تاريخ استحقاق الدين
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trader_taxes', function (Blueprint $table) {
            //
        });
    }
};
