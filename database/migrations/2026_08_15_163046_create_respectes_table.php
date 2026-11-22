<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respectes', function (Blueprint $table) {

            $table->id();

            $table->string('resaux_social')->nullable();

            $table->string('full_name_of_moussayer');

            $table->string('phone_of_moussayer')->nullable();

            $table->date('date_of_this')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respectes');
    }
};