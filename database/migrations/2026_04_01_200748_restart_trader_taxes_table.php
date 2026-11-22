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
        $table->dropColumn([
            'revenue', 'valeur_tax_IFU', 'pay_total', 'date_pay',
            'pay_tranche1', 'date_tranche1', 'pay_tranche2', 'date_tranche2',
            'pay_tranche3', 'date_tranche3', 'notes', 'receipt_number',
            'receipt1_number', 'receipt2_number', 'receipt3_number', 'tax_type'
        ]);
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
