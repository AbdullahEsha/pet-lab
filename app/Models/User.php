<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_bn',
        'email',
        'password',
        'image',
        'phone',
        'address',
        'city',
        'father_name',
        'mother_name',
        'date_of_birth',
        'blood_type',
        'gender',
        'profession',
        'name_of_institution',
        'nid_or_passport_image',
        'nid_or_passport_image_back',
        'facebook_id_link',
        'role',
        'labId',
        'subExpDate',
        'isBva',
        'isApproved',
        'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'subExpDate' => 'datetime',
    ];
}
