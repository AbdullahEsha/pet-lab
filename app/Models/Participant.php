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
        'phone',
        'data',
        'isGuest',
        'event_id',
        'isApproved'
    ];

    // Define the relationship with the Event model
    // in the participants table, the event_id column is used to store the id of the event that the participant is associated with
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
