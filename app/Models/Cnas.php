<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cnas extends Model
{
    use HasFactory;

    protected $fillable = [

        'full_name',
        'NIN',
        'phone',
        'code',
        'mot_de_passe',

        'prove_pdf',
        'rent_pdf',
        'register_pdf',
        'craft_cart_pdf',
        'cart_pdf',
        'birth_certificate_pdf',
        'nif_pdf',
        'chek_barre_pdf',

    ];

    public function beneficiaries()
    {
        return $this->hasMany(CnasBeneficiary::class);
    }
}