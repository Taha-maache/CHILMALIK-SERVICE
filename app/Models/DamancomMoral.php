<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamancomMoral extends Model
{
    protected $table = 'damancom_moral';

    protected $fillable = [
        'label_name',
        'NIN',
        'phone',
        'code',
        'mot_de_passe',
        'prove_pdf',
    ];
}