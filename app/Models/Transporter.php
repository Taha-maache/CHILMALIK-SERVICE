<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
     protected $fillable = [
        'number_of_registration',
        'type_of_vehicle',
        'category_of_vehicle',
        'load_total',
        'first_year_of_using',
        'first_name',
        'last_name',
        'first_namefr',
        'last_namefr',
        'date_of_birth',
        'place_of_birth',
        'activity',
        'number_of_identity_card',
        'phone',
        'address',
        'email',
        'first_last_name_of_driver',
        'date_of_birth_of_driver',
        'place_of_birth_of_driver',
        'address_of_driver',
        'phone_of_driver',
        'object',
        'carriers_registry_number',
        'register_pdf',
'scanner_pdf',
'carte_grise_pdf',
'mou9arar_na9l_pdf',
'kafaa_pdf',
'permit_pdf',
'permit_cerculer_pdf',
'casnos_pdf',
'nif_pdf',
    ];
}
