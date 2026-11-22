<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('traders', function (Blueprint $table) {

            $table->timestamp('transfere_cnrc_at')->nullable();
            $table->timestamp('recupere_cnrc_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {

            $table->dropColumn([
                'transfere_cnrc_at',
                'recupere_cnrc_at'
            ]);

        });
    }
};