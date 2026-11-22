<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respecte extends Model
{
    protected $fillable = [
        'resaux_social',
        'full_name_of_moussayer',
        'phone_of_moussayer',
        'date_of_this',
    ];

    protected $casts = [
        'date_of_this' => 'date',
    ];
}