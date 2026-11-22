<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\form;

class Trader extends Model
{
    use HasFactory;

    protected $table = 'traders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'first_nameFR',
        'last_nameFR',
        'date_of_birth',
        'place_of_birth',
        'NIN',
        'number_card',
        'date1_card',
        'date2_card',
        'place_card',
        'father_name',
        'mother_name',
        'nationality',
        'county_code',
        'state',
        'gender',
        'marital_status',
        'address',
        'address_fr',
        'phone',
        'fax',
        'email',
        'signature_image',
        'Rationalization_contract_number',
        'state_RC',
        'Number_RC',
        'sequence_number_RC',
        'deposit_number_RC',
        'deposit_date_RC',
        'nature_RC',
        'form_BA',
        'nature_local',
        'Business_address',
        'Municipality_code_Business',
        'state_Business',
        'Activity_start_date',
        'Rental_period',
        'date1',
        'date2',
        'Name_surname_landlord',
        'legal_nature_CP',
        'Subordination_CP',
        'Commercial_base_dependency',
        'place_activity_Non_permanent_trade',
        'Municipality_code_Business_Non_permanent_trade',
        'state_Non_permanent_trade',
        'Modification',
        'production_of_goods',
        'Wholesale_distribution',
        'Retail_distribution',
        'Services',
        'Export', 
        'Date_of_this_register',
        'is_casnos_declared',
        'register_pdf',
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'activity_id',
        'activity_fr_id',
        'name_agence',
'number_card_agence',
'date_card_agence',
'municipality_agence',
'rent_pdf',
'birth_certificate_pdf',
'cart_pdf',
'residence_pdf',      
'nif',
'number_of_register',
'cpi',
'activity_address_g08',
'starting_date',
'place_g08',  
'status',
'transfere_cnrc_at',
'recupere_cnrc_at',
'operation_type',
'number_of_codes',
'main_activity_fr_id',


        


    ];
protected $casts = [
    'operation_type' => 'array',
];
    public function traderTaxes()
{
    return $this->hasMany(TraderTax::class);
}
public function casnosPayments()
{
    return $this->hasMany(CasnosPayment::class);
}
public function activities()
{
    return $this->belongsToMany(Activity::class, 'activity_trader');
}
public function activitiesFr()
{
    return $this->belongsToMany(ActivityFr::class, 'activityfr_trader');
}
public function mainActivityFr()
{
    return $this->belongsTo(
        \App\Models\ActivityFr::class,
        'main_activity_fr_id'
    );
}
}
