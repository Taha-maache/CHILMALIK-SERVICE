<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CasnosPaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'casnos_payment_transactions';

    protected $fillable = [
        'client_name',
        'casnos_payment_id',
        'amount',
        'payment_date',
        'reference',
        'invoice_number',
        'description',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function casnosPayment()
    {
        return $this->belongsTo(CasnosPayment::class, 'casnos_payment_id');
    }
}