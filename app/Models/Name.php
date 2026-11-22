<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
protected $fillable = [
    'full_name',
    'address',

    'nom_commercial_ar_1',
    'nom_commercial_ar_2',
    'nom_commercial_ar_3',
    'nom_commercial_ar_4',

    'type',
    'form_juridique',
    
    'nom_commercial_fr_1',
    'nom_commercial_fr_2',
    'nom_commercial_fr_3',
    'nom_commercial_fr_4',
];
}
