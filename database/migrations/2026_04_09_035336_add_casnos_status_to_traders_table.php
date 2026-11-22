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
            // هنا نكتبو الكود الجديد باش يتزاد الحقل
            $table->boolean('is_casnos_declared')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            // هنا نحيو الحقل لو حبينا نلغيو الـ migration
            $table->dropColumn('is_casnos_declared');
        });
    }
};