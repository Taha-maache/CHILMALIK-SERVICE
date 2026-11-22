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
    Schema::table('cnas_beneficiaries', function (Blueprint $table) {
        $table->string('photo_pdf')->nullable()->after('cart_pdf');
    });
}

public function down()
{
    Schema::table('cnas_beneficiaries', function (Blueprint $table) {
        $table->dropColumn('photo_pdf');
    });
}
};
