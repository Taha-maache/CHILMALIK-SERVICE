<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        // نزيدو الكولوم date ونخلوه nullable باش ميفسدش البيانات القديمة
        $table->date('registration_date')->nullable()->after('number_of_demande');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        // هادي باش إذا حبيت ترجع لور تنحي الكولوم
        $table->dropColumn('registration_date');
    });
}
};
