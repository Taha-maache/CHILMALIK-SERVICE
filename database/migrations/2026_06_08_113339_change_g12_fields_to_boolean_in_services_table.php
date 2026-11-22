<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // نحول القيم القديمة إلى 0 أو 1
        DB::table('services')->update([
            'g12_price' => DB::raw('CASE WHEN g12_price > 0 THEN 1 ELSE 0 END'),
        ]);

        DB::table('services')->update([
            'g12bis_price' => DB::raw('CASE WHEN g12bis_price > 0 THEN 1 ELSE 0 END'),
        ]);

        Schema::table('services', function (Blueprint $table) {
            $table->boolean('g12_price')->default(false)->change();
            $table->boolean('g12bis_price')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('g12_price', 10, 2)->default(0)->change();
            $table->decimal('g12bis_price', 10, 2)->default(0)->change();
        });
    }
};