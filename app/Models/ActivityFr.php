<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityFr extends Model
{
    protected $table = 'activities_fr';

    protected $fillable = [
        'code',
        'activity'
    ];
   public function traders()
{
    return $this->belongsToMany(Trader::class);
}
public function taxes()
{
    return $this->hasMany(Tax::class);
}
public function tmorals()
{
    return $this->belongsToMany(Tmoral::class);
}   
}
