<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $fillable = [
        'tmoral_id',
        'full_name',
        'NIN',
        'adjectif',
        'address',
        'nationality',
        'date_of_birth',
        'place_of_birth',
        'father_name',
        'mother_name',
    ];

    public function tmoral()
    {
        return $this->belongsTo(Tmoral::class);
    }
}