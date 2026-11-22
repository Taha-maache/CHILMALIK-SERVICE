<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tmorals', function (Blueprint $table) {
            $table->id();

            // Personal info
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
            $table->string('county_code')->nullable();
            $table->string('state')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();

            $table->text('address')->nullable();
            $table->text('address_fr')->nullable();

            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();

            $table->string('signature_image')->nullable();

            // RC
            $table->string('Rationalization_contract_number')->nullable();
            $table->string('state_RC')->nullable();
            $table->string('Number_RC')->nullable();
            $table->string('sequence_number_RC')->nullable();
            $table->string('deposit_number_RC')->nullable();
            $table->date('deposit_date_RC')->nullable();
            $table->string('nature_RC')->nullable();
            $table->string('nature_local')->nullable();

            // Business
            $table->string('Business_address')->nullable();
            $table->string('Municipality_code_Business')->nullable();
            $table->string('state_Business')->nullable();
            $table->date('Activity_start_date')->nullable();
            $table->string('Rental_period')->nullable();

            $table->date('date1')->nullable();
            $table->date('date2')->nullable();

            $table->string('Name_surname_landlord')->nullable();
            $table->string('legal_nature_CP')->nullable();

            $table->string('place_activity_Non_permanent_trade')->nullable();
            $table->string('Municipality_code_Business_Non_permanent_trade')->nullable();
            $table->string('state_Non_permanent_trade')->nullable();

            $table->text('Modification')->nullable();

            // YES/NO fields (boolean)
            $table->boolean('production_of_goods')->default(false);
            $table->boolean('Wholesale_distribution')->default(false);
            $table->boolean('Retail_distribution')->default(false);
            $table->boolean('Services')->default(false);
            $table->boolean('Export')->default(false);
            $table->boolean('Craft_production')->default(false);
            $table->boolean('Import_for_resale_asis')->default(false);

            $table->date('Date_of_this_register')->nullable();

            $table->boolean('is_casnos_declared')->default(false);

            // files
            $table->string('register_pdf')->nullable();
            $table->string('nif_pdf')->nullable();
            $table->string('nis_pdf')->nullable();
            $table->string('g8_pdf')->nullable();

            // relations
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('activity_fr_id')->nullable();

            // company info
            $table->string('Social_label_ar')->nullable();
            $table->string('Social_label_fr')->nullable();
            $table->string('Trade_name_ar')->nullable();
            $table->string('Trade_name_fr')->nullable();

            $table->string('Legal_form_of_company_ar')->nullable();
            $table->string('Legal_form_of_company_fr')->nullable();

            $table->decimal('Social_capital', 15, 2)->nullable();

            $table->text('Social_address')->nullable();
            $table->string('Municipal_code_social_headquarters')->nullable();
            $table->string('Social_state')->nullable();

            $table->string('adjectif')->nullable();
            $table->string('Social_label_institution')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tmorals');
    }
};