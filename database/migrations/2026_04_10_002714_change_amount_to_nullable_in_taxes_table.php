<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxes', function (Blueprint $table) {
            // نعدلو الحقل باش يولي nullable()
            // استعمل change() باش يطبق التعديل بلا ما يمسح البيانات
            $table->decimal('amount', 15, 2)->nullable()->change();
            
            // نزيدو حتى credit_date نرجعوه nullable() إذا ماكانش
            $table->date('credit_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('taxes', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->nullable(false)->change();
            $table->date('credit_date')->nullable(false)->change();
        });
    }
};