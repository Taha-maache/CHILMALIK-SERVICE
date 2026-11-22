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
    Schema::table('taxes', function (Blueprint $table) {
        // نزيدو مبلغ الدفع الأولي، ويكون 0 كقيمة افتراضية
        $table->decimal('amount', 15, 2)->default(0)->after('tax_value');
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
