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
    Schema::table('traders', function (Blueprint $table) {
        // نزيدو العمود الجديد، ونقدرو نديروه nullable إذا كان ماشي إجباري
        $table->string('address_fr')->nullable()->after('address'); 
    });
}

public function down()
{
    Schema::table('traders', function (Blueprint $table) {
        $table->dropColumn('address_fr');
    });
}
};
