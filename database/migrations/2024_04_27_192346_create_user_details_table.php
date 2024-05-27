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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('date_of_birth');
            $table->string('blood_type');
            $table->string('gender');
            $table->string('profession')->nullable();
            $table->string('name_of_institution')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('nid_or_passport_image');
            $table->string('nid_or_passport_image_back');
            $table->string('facebook_id_link')->nullable();
            $table->string('aviary_name')->nullable();
            $table->string('aviary_address')->nullable();
            $table->string('quantity_of_birds')->nullable();
            $table->json('bird_species_collection')->nullable();
            $table->string('aviary_facebook_link')->nullable();
            $table->boolean('aviary_have_any_partner');
            $table->integer('number_of_partner')->nullable();
            $table->json('partners_details')->nullable();
            $table->boolean('isApproved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
