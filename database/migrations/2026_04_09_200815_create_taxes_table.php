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
    Schema::create('taxes', function (Blueprint $table) {
        $table->id();
        
        // المعلومات الشخصية (بالعربية والفرنسية)
        $table->string('first_name');
        $table->string('last_name');
        $table->string('first_nameFR');
        $table->string('last_nameFR');

        // معلومات الضريبة
        $table->string('tax_type'); // نوع الضريبة (IFU, IRG...)
        $table->integer('tax_year'); // السنة
        $table->decimal('tax_value', 15, 2); // القيمة المالية
        $table->string('pay_type'); // طريقة الدفع

        // أرقام التعريف
        $table->string('BP')->nullable();
        $table->string('Nif')->nullable();
        $table->string('NIN')->nullable();
        $table->string('structure')->nullable(); // الهيكل (مثلا CPI AIN OULMENE)
        $table->string('number_of_commerce')->nullable(); // رقم السجل التجاري
        $table->string('numero_matiere')->nullable();

        // العناوين والتواريخ
        $table->date('date_start')->nullable();
        $table->string('place')->nullable();
        $table->text('adrress_activity')->nullable();
        $table->text('addres_FR')->nullable();
        $table->date('credit_date')->nullable();

        // الاتصال
        $table->string('phone')->nullable();
        $table->string('email')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
