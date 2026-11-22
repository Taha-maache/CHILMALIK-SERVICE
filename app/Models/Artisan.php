<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    protected $fillable = [
        'full_name',
        'NIN',
        'phone',
        'number_of_registration',
        'number_of_casnos',
        'etat',
    ];
}