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
        // نزيدو الحقل ونخلوه يقبل يكون فارغ (nullable) باش ما يديرش مشاكل مع البيانات القديمة
        $table->date('Date_of_this_register')->nullable();
    });
}

public function down(): void
{
    Schema::table('traders', function (Blueprint $table) {
        $table->dropColumn('Date_of_this_register');
    });
}
};
