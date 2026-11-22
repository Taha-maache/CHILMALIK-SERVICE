<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'social_label',
        'authorized_person_identity',
        'mentioned',
        'date_of_this',
        'percentage',
        'full_identity',
        'nationalities',
        'full_name',
        'date_of_birth',
        'place_of_birth',
        'address',
        'number_card',
        'date1_card',
        'date2_card',
        'place_card',
        'number_of_passport',
        'date1_passport',
        'date2_passport',
        'place_passport',
        'other_document',
        'found',
          'declaration_date',
    'number_of_register',
    'demande',
    'social_label_fr',
'authorized_person_identity_fr',
'full_identity_fr',
'nationalities_fr',
'full_name_fr',
'place_of_birth_fr',
'address_fr',
'place_card_fr',
'place_passport_fr',
'other_document_fr',
'cart_pdf',
    ];
}