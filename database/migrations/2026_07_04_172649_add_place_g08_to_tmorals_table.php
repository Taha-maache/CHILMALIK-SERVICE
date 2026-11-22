<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tmorals', function (Blueprint $table) {
            $table->string('place_g08', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tmorals', function (Blueprint $table) {
            $table->dropColumn('place_g08');
        });
    }
};