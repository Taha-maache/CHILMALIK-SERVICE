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
    Schema::table('credits', function (Blueprint $table) {
        $table->timestamp('last_whatsapp_reminder_at')->nullable()->after('amount_paid');
    });
}

public function down(): void
{
    Schema::table('credits', function (Blueprint $table) {
        $table->dropColumn('last_whatsapp_reminder_at');
    });
}
};
