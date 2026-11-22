<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('casnos', function (Blueprint $table) {
            $table->timestamp('last_whatsapp_reminder_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('casnos', function (Blueprint $table) {
            $table->dropColumn('last_whatsapp_reminder_at');
        });
    }
};