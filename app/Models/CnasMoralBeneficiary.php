<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CnasMoralBeneficiary extends Model
{
    protected $fillable = [

        'cnas_moral_id',
        'full_name',
        'cart_pdf',
        'photo_pdf',
        'residence_pdf',

    ];

    public function cnasMoral()
    {
        return $this->belongsTo(CnasMoral::class);
    }
}