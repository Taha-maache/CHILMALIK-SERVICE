<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->foreignId('main_activity_fr_id')
                ->nullable()
                
                ->constrained('activities_fr')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->dropForeign(['main_activity_fr_id']);
            $table->dropColumn('main_activity_fr_id');
        });
    }
};