<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CnasBeneficiary extends Model
{
    use HasFactory;

    protected $fillable = [

        'cnas_id',
        'full_name',
        'cart_pdf',
        'photo_pdf',
        'birth_pdf',
        
    ];

    public function cnas()
    {
        return $this->belongsTo(Cnas::class);
    }
}