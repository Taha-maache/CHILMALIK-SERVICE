<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();

            $table->string('social_label')->nullable();
            $table->string('authorized_person_identity')->nullable();
            $table->enum('mentioned', ['oui', 'non'])->nullable();
            $table->date('date_of_this')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();

            $table->string('full_identity')->nullable();
            $table->string('full_name')->nullable();
            $table->string('nationalities')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->text('address')->nullable();

            $table->string('number_card')->nullable();
            $table->date('date1_card')->nullable();
            $table->date('date2_card')->nullable();
            $table->string('place_card')->nullable();

            $table->string('number_of_passport')->nullable();
            $table->date('date1_passport')->nullable();
            $table->date('date2_passport')->nullable();
            $table->string('place_passport')->nullable();

            $table->string('other_document')->nullable();
            $table->enum('found', ['oui', 'non'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};