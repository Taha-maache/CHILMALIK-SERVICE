<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tmoral extends Model
{
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
        'place_activity_Non_permanent_trade',
        'Municipality_code_Business_Non_permanent_trade',
        'state_Non_permanent_trade',
        'Modification',
        'production_of_goods',
        'Wholesale_distribution',
        'Retail_distribution',
        'Services',
        'Export',
        'Craft_production',
        'Import_for_resale_asis',
        'Date_of_this_register',
        'is_casnos_declared',
        'register_pdf',
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'activity_id',
        'activity_fr_id',
        'Social_label_ar',
        'Social_label_fr',
        'Trade_name_ar',
        'Trade_name_fr',
        'Legal_form_of_company_ar',
        'Legal_form_of_company_fr',
        'Social_capital',
        'Social_address',
        'Municipal_code_social_headquarters',
        'Social_state',
        'adjectif',
        'Social_label_institution',
        'Subordination_CP',
        'Commercial_base_dependency',
        'name_agence',
'number_card_agence',
'date_card_agence',
'municipality_agence',
  'naming_pdf',
    'rent_pdf',
    'essential_law_pdf',
    'Boal_pdf',
    'fiche_navet_pdf',
'nif',
'number_of_register',
'cpi',
'activity_address_g08',
'starting_date',
'place_g08',
'status',
'transfere_cnrc_at',
'recupere_cnrc_at',

    ];
  
public function representatives()
{
    return $this->hasMany(Representative::class);
}  
public function activities()
{
    return $this->belongsToMany(Activity::class, 'activity_tmoral');
}

public function activitiesFr()
{
    return $this->belongsToMany(
        ActivityFr::class,
        'activityfr_tmoral', // اسم الجدول
        'tmoral_id',         // FK ديال tmoral
        'activityfr_id'      // FK ديال activity (بدون underscore)
    );
}
}