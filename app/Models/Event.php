<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'location',
        'fees_user',
        'fees_guest',
        'tShirtSize',
        'pickUpLocation',
        'isTshirt',
        'allow_birds',
        'allow_guest',
        'starts_at',
        'ends_at',
        'expires_at',
    ];
}
