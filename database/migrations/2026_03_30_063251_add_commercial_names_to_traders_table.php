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
    Schema::table('traders', function (Blueprint $table) {
        $table->text('Nom_commercial')->nullable(); // استعملنا text باش يرفد 4 أسطر
        $table->text('Nom_commercial_AR')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            //
        });
    }
};
