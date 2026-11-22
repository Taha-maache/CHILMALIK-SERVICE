<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
    'first_name', 'last_name', 'first_nameFR', 'last_nameFR',
    'tax_type', 'tax_year', 'tax_value', 'pay_type',
    'BP', 'Nif', 'structure', 'number_of_commerce', 
    'date_start', 'place', 'numero_matiere', 'adrress_activity',
    'credit_date', 'NIN', 'addres_FR', 'phone', 'email','amount','nif_pdf',
'nis_pdf',
'g12_pdf',
'g12bis_pdf',
'matricule',
'username', 'password',
'activity_id',
'activity_fr_id',

];
public function activity()
{
    return $this->belongsTo(Activity::class, 'activity_id');
}
public function activityFr()
{
    return $this->belongsTo(ActivityFr::class, 'activity_fr_id');
}
public function payments()
{
    return $this->hasMany(TaxesPayment::class);
}
}
