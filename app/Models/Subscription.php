<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'start_date',
        'end_date',
        'status',
        'total_amount',
    ];


public function payments()
{
    return $this->hasMany(\App\Models\SubscriptionPayment::class);
}

public function getTotalPaidAttribute()
{
    return $this->payments()->sum('amount');
}

public function getRemainingAmountAttribute()
{
    return max(0, 10000 - $this->total_paid);
}
public function renewals()
{
    return $this->hasMany(
        \App\Models\SubscriptionRenewal::class,
        'subscription_id'
    );
}
 }