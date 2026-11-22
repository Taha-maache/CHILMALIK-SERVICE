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
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone')->nullable(); // nullable إذا كان الهاتف ماشي ضروري
        $table->string('email')->unique();   // unique باش ما يتعاودش الإيميل
        $table->string('password');
        $table->string('number_of_registration')->unique(); // رقم السجل
        $table->integer('number_of_demande')->default(0);   // يبدأ من 0
        $table->timestamps(); // كريي d'office created_at و updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
