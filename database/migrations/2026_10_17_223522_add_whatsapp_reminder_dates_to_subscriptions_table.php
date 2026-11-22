
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->timestamp('last_whatsapp_balance_reminder_at')
                ->nullable();

            $table->timestamp('last_whatsapp_renewal_reminder_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'last_whatsapp_balance_reminder_at',
                'last_whatsapp_renewal_reminder_at',
            ]);
        });
    }
};
