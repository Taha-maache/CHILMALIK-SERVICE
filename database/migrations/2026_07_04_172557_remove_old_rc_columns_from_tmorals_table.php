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
        $table->dropColumn([
            'state_RC',
            'Number_RC',
            'sequence_number_RC',
            'deposit_number_RC',
            'deposit_date_RC',
        ]);
    });
}
    /**
     * Reverse the migrations.
     */
 public function down(): void
{
    Schema::table('tmorals', function (Blueprint $table) {
        $table->string('state_RC')->nullable();
        $table->string('Number_RC')->nullable();
        $table->string('sequence_number_RC')->nullable();
        $table->string('deposit_number_RC')->nullable();
        $table->string('deposit_date_RC')->nullable();
    });
}

};
