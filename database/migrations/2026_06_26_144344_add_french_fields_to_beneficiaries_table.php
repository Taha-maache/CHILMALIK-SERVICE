<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->string('social_label_fr')->nullable();
            $table->string('authorized_person_identity_fr')->nullable();
            $table->string('full_identity_fr')->nullable();
            $table->string('nationalities_fr')->nullable();
            $table->string('full_name_fr')->nullable();
            $table->string('place_of_birth_fr')->nullable();
            $table->text('address_fr')->nullable();
            $table->string('place_card_fr')->nullable();
            $table->string('place_passport_fr')->nullable();
            $table->string('other_document_fr')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn([
                'social_label_fr',
                'authorized_person_identity_fr',
                'full_identity_fr',
                'nationalities_fr',
                'full_name_fr',
                'place_of_birth_fr',
                'address_fr',
                'place_card_fr',
                'place_passport_fr',
                'other_document_fr',
            ]);
        });
    }
};