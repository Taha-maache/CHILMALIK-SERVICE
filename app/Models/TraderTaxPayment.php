<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TraderTaxPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_tax_id',
        'payment_date',
        'amount',
        'reference',
        'description',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function traderTax()
    {
        return $this->belongsTo(TraderTax::class);
    }
}