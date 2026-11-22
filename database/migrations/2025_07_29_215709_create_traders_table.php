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
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_nameFR')->nullable();
            $table->string('last_nameFR')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('NIN')->nullable();
            $table->string('number_card')->nullable();
            $table->date('date1_card')->nullable();
            $table->date('date2_card')->nullable();
            $table->string('place_card')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nationality')->nullable();
            $table->enum('gender', ['ذكر', 'أنثى'])->nullable();
            $table->enum('marital_status', ['أعزب', 'متزوج', 'مطلق', 'أخرى'])->nullable();
            $table->text('address')->nullable();
            $table->string('county_code')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('signature_image')->nullable();
            $table->string('Rationalization_contract_number')->nullable();
            $table->string('state_RC')->nullable();
            $table->string('Number_RC')->nullable();
            $table->string('sequence_number_RC')->nullable();
            $table->string('deposit_number_RC')->nullable();
            $table->date('deposit_date_RC')->nullable();
            $table->enum('nature_RC', ['قيد جديد', 'تعديل'])->nullable();
            $table->enum('form_BA', ['تجارة قارة', 'تجارة غير قارة'])->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->enum('nature_local', ['رئيسي', 'ثانوي'])->nullable();
            $table->string('Business_address')->nullable();
            $table->string('Municipality_code_Business')->nullable();
            $table->string('state_Business')->nullable();
            $table->date('Activity_start_date')->nullable();
            $table->string('Rental_period')->nullable();
            $table->date('date2')->nullable();
            $table->string('date1')->nullable();
            $table->string('Name_surname_landlord')->nullable();
            $table->enum('legal_nature_CP', ['ايجار', 'ملكية'])->nullable();
            $table->string('Subordination_CP')->nullable();
            $table->string('Commercial_base_dependency')->nullable();
            $table->string('place_activity_Non_permanent_trade')->nullable();
            $table->string('Municipality_code_Business_Non_permanent_trade')->nullable();
            $table->string('state_Non_permanent_trade')->nullable();
            $table->string('Modification')->nullable();
            $table->enum('production_of_goods', ['non', 'oui'])->nullable();
            $table->enum('Wholesale_distribution', ['non', 'oui'])->nullable();
            $table->enum('Retail distribution', ['non', 'oui'])->nullable();
            $table->enum('Services', ['non', 'oui'])->nullable();
            $table->enum('Export', ['non', 'oui'])->nullable();
            $table->enum('Retail_distribution', ['non', 'oui'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traders');
    }
};
