<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Efficacite extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'date_Paiment_fichier',
        'etat',
    ];

    protected $casts = [
        'date_Paiment_fichier' => 'date',
    ];
}