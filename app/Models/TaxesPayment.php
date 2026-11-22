<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_id',
        'payment_date',
        'amount',
        'reference',
        'description',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Payment belongs to one Tax
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}