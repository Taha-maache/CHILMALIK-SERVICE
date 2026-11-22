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
    Schema::table('trader_taxes', function (Blueprint $table) {
        $table->decimal('amount', 15, 2)->nullable()->after('pay_type');
        $table->date('credit_date')->nullable()->change(); // التأكد أنه يقبل null
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
