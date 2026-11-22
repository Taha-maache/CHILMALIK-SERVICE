<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damancom extends Model
{
protected $fillable = [
    'full_name',
    'NIN',
    'phone',
    'code',
    'mot_de_passe',
    'prove_pdf',
];
}
