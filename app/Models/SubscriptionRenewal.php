<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionRenewal extends Model
{
    protected $fillable = [
        'subscription_id',
        'start_date',
        'end_date',
        'amount',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payments()
{
    return $this->hasMany(
        \App\Models\SubscriptionPayment::class,
        'renewal_id'
    );
}
    public function getTotalPaidAttribute()
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, (float) $this->amount - $this->total_paid);
    }
}
