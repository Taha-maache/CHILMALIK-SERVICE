<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
protected $fillable = [
    'first_name', 
    'last_name', 
    'phone', 
    'email', 
    'password', 
    'number_of_registration', 
    'number_of_demande',
    'registration_date',
    'client_class',
];
//
}
