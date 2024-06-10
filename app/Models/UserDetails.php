<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'aviary_name',
        'aviary_address',
        'quantity_of_birds',
        'bird_species_collection',
        'aviary_facebook_link',
        'aviary_have_any_partner',
        'number_of_partner',
        'partners_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
