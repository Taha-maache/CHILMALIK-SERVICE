<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // المعلومات الشخصية
            $table->string('full_name');
            $table->string('phone');
            $table->string('address');
            $table->boolean('is_subscriber')->default(false); // اشتراك نعم/لا
            $table->date('abonnement_start')->nullable(); // تاريخ بداية الاشتراك
            $table->date('abonnement_end')->nullable();   // تاريخ نهاية الاشتراك
            
            // خدمات السجل التجاري
            $table->boolean('sijil_moutanaiqil')->default(false);
            $table->integer('sijil_ramz_count')->default(0);
            $table->boolean('naql_badaie')->default(false);
            $table->boolean('hanout')->default(false);
            $table->boolean('sina3a')->default(false);
            $table->boolean('eljemla')->default(false);
            $table->boolean('wakala')->default(false);

            // خدمات الضرائب
            $table->boolean('casnos')->default(false);
            $table->boolean('carte_chifa')->default(false);
            $table->decimal('g12_price', 10, 2)->default(0);
            $table->decimal('g12bis_price', 10, 2)->default(0);
            $table->boolean('nif_plus_g08')->default(false);
            $table->integer('cnas_type')->default(0); // 0=none, 1=1.5M, 2=1.2M
            
            // خدمات أخرى
            $table->boolean('nis')->default(false);
            $table->boolean('inapi')->default(false);
            $table->decimal('logo_price', 10, 2)->default(0);
            $table->boolean('coderbar')->default(false);
            $table->integer('coderbar_products_count')->default(0);
            $table->boolean('moudirya_naql')->default(false);
            $table->string('khatm_type')->nullable();
            $table->decimal('khatm_price', 10, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};