<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->id();

            $table->string('object')->nullable();
            $table->string('number_of_registration')->nullable();
            $table->string('type_of_vehicle')->nullable();
            $table->string('category_of_vehicle')->nullable();
            $table->string('load_total')->nullable();
            $table->string('first_year_of_using')->nullable();

            // transporter info
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_namefr')->nullable();
            $table->string('last_namefr')->nullable();

            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();

            $table->string('activity')->nullable();
            $table->string('number_of_identity_card')->nullable();

            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();

            // driver info
            $table->string('first_last_name_of_driver')->nullable();
            $table->date('date_of_birth_of_driver')->nullable();
            $table->string('place_of_birth_of_driver')->nullable();
            $table->string('address_of_driver')->nullable();
            $table->string('phone_of_driver')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporters');
    }
};