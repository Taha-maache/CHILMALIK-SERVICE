<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JibayaticMoral extends Model
{
    protected $table = 'jibayatic_moral';

    protected $fillable = [
        'label_name',
        'NIN',
        'phone',
        'code',
        'mot_de_passe',
        'prove_pdf',
    ];
}