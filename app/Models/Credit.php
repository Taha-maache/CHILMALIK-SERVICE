<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'service_id',
        'amount_paid',
        'last_whatsapp_reminder_at',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
public function getAmountPaidAttribute()
{
    return $this->payments()->sum('amount');
}
    public function getRemainingAmountAttribute()
    {
        return $this->service->total_price - $this->amount_paid;
    }
    public function getTotalAmountAttribute()
{
    return $this->service->total_price;
}
    public function payments()
{
    return $this->hasMany(CreditPayment::class);
}
}