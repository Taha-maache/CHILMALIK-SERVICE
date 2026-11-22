<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CnasMoral extends Model
{
    protected $fillable = [

        'label_name',
        'NIN',
        'phone',
        'code',
        'mot_de_passe',

        'prove_pdf',
        'rent_pdf',
        'G08_pdf',
        'register_pdf',
        'cart_pdf',
        'residence_pdf',
        'Boal_pdf',
        'rential_law_pdf',
        'Nif_pdf',
        'chek_baree_pdf',

    ];

    public function beneficiaries()
    {
        return $this->hasMany(CnasMoralBeneficiary::class);
    }
}