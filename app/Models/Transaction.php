<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactionId', 
        'amount', 
        'narration', // it can be for subscription or event participation or any other transaction
        'userId'
    ];
}
