<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Schema::create('events', function (Blueprint $table) {
//     $table->id();
//     $table->string('title');
//     $table->text('description')->nullable();
//     $table->string('event_type');
//     $table->string('location');
//     $table->double('fees_user', 8, 2)->nullable(); // 8 digits in total, 2 after the decimal point
//     $table->double('fees_guest', 8, 2)->nullable(); // 8 digits in total, 2 after the decimal point
//     $table->string('tShirtSize')->nullable();
//     $table->string('pickupLocation')->nullable();
//     $table->json('birdData')->nullable();
//     $table->boolean('allow_tShirt')->nullable();
//     $table->boolean('allow_birds')->nullable();
//     $table->boolean('allow_guest')->nullable();
//     $table->boolean('allow_pickup')->nullable();
//     $table->date('starts_at');
//     $table->date('ends_at');
//     $table->date('expires_at');
//     $table->timestamps();
// });
  
class event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'location',
        'image',
        'fees_user',
        'fees_guest',
        'tShirtSize',
        'pickupLocation',
        'birdData',
        'allow_tShirt',
        'allow_birds',
        'allow_guest',
        'allow_pickup',
        'starts_at',
        'ends_at',
        'expires_at'
    ];
}