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
       Schema::create('names', function (Blueprint $table) {
    $table->id();

    $table->string('full_name');
    $table->string('address');

    // بالعربية
    $table->string('nom_commercial_ar_1')->nullable();
    $table->string('nom_commercial_ar_2')->nullable();
    $table->string('nom_commercial_ar_3')->nullable();
    $table->string('nom_commercial_ar_4')->nullable();

    // بالفرنسية
    $table->string('nom_commercial_fr_1')->nullable();
    $table->string('nom_commercial_fr_2')->nullable();
    $table->string('nom_commercial_fr_3')->nullable();
    $table->string('nom_commercial_fr_4')->nullable();

    $table->timestamps();
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('names');
    }
};
