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
    Schema::table('tmorals', function (Blueprint $table) {
        $table->string('Subordination_CP')->nullable();
        $table->string('Commercial_base_dependency')->nullable();
    });
}

public function down(): void
{
    Schema::table('tmorals', function (Blueprint $table) {
        $table->dropColumn([
            'Subordination_CP',
            'Commercial_base_dependency'
        ]);
    });
}
};
