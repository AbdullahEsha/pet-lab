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
        'father_name',
        'mother_name',
        'date_of_birth',
        'blood_type',
        'gender',
        'profession',
        'name_of_institution',
        'nid_no',
        'passport_number',
        'nid_or_passport_image',
        'nid_or_passport_image_back',
        'facebook_id_link',
        'aviary_name',
        'aviary_address',
        'quantity_of_birds',
        'bird_species_collection',
        'aviary_facebook_link',
        'aviary_have_any_partner',
        'number_of_partner',
        'partners_details',
        'isApproved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
