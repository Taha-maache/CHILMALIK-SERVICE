<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('taxes', function (Blueprint $table) {
        // نغيرو الحقل باش يولي يقبل NULL
        $table->string('tax_type')->nullable()->change();
    });
}

public function down()
{
    Schema::table('taxes', function (Blueprint $table) {
        // نرجعوه إجباري في حالة حبيت ترجع (Rollback)
        $table->string('tax_type')->nullable(false)->change();
    });
}
};
