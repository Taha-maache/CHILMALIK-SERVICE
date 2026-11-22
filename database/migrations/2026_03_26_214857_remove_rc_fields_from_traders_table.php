<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->dropColumn([
                'state_RC',
                'Number_RC',
                'sequence_number_RC',
                'deposit_number_RC',
                'deposit_date_RC'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->string('state_RC')->nullable();
            $table->string('Number_RC')->nullable();
            $table->string('sequence_number_RC')->nullable();
            $table->string('deposit_number_RC')->nullable();
            $table->date('deposit_date_RC')->nullable();
        });
    }
};