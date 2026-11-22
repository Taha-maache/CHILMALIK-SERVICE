<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tmorals', function (Blueprint $table) {

            $table->string('name_agence')
                ->default('شيل عبد المالك');

            $table->string('number_card_agence')
                ->default('416227061');

            $table->string('date_card_agence')
                ->default('3.11.2025');

            $table->string('municipality_agence')
                ->default('عين ولمان');

        });
    }

    public function down(): void
    {
        Schema::table('tmorals', function (Blueprint $table) {

            $table->dropColumn([
                'name_agence',
                'number_card_agence',
                'date_card_agence',
                'municipality_agence'
            ]);

        });
    }
};