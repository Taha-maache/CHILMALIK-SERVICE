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
        $table->string('rent_pdf')->nullable();
        $table->string('birth_certificate_pdf')->nullable();
        $table->string('cart_pdf')->nullable();
        $table->string('residence_pdf')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
 public function down(): void
{
    Schema::table('traders', function (Blueprint $table) {
        $table->dropColumn([
            'rent_pdf',
            'birth_certificate_pdf',
            'cart_pdf',
            'residence_pdf',
        ]);
    });
}
};
