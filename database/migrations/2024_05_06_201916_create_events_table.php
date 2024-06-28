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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('event_type');
            $table->string('location');
            $table->double('fees_user', 8, 2)->nullable(); // 8 digits in total, 2 after the decimal point
            $table->double('fees_guest', 8, 2)->nullable(); // 8 digits in total, 2 after the decimal point
            $table->date('starts_at');
            $table->date('ends_at');
            $table->date('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
