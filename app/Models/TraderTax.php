<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // لازم تزيد هادي

class TraderTax extends Model
{
    protected $primaryKey = 'id';
    protected $casts = [
        'tax_value' => 'float',
    ];

 protected $fillable = [
    'trader_id', 'tax_type', 'tax_year', 'tax_value', 'pay_type',
    'BP', 'Nif', 'structure', 'number_of_commerce', 
    'date_start', 'place', 'numero_matiere', 'adrress_activity','credit_date', 'amount',
    'g12_pdf',
    'g12bis_pdf',
    'matricule',
    'username', 'password',
];

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
 
public function isLate()
{
    // المنطق الجديد: إذا كان "دين" وفات تاريخ الاستحقاق (credit_date)
    return $this->pay_type === 'credit' && 
           $this->credit_date && 
           \Carbon\Carbon::parse($this->credit_date)->isPast();
}
public function payments()
{
    return $this->hasMany(TraderTaxPayment::class);
}
}