<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('names', function (Blueprint $table) {

            $table->string('type')->default('physique');
            $table->string('form_juridique')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('names', function (Blueprint $table) {

            $table->dropColumn('type');
            $table->dropColumn('form_juridique');

        });
    }
};