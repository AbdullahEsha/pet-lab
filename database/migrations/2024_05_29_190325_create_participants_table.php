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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('image')->nullable();
            $table->string('t_shirt_size')->nullable();
            $table->string('phone');
            $table->json('data')->nullable();
            $table->boolean('isGuest');
            $table->string('event_id');
            $table->string('isApproved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
