<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';

    protected $fillable = [
        'name',
        'address',
        'image',
        't_shirt_size',
        'data',
        'event_id',
        'isApproved'
    ];
}
