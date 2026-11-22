<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasnosPm extends Model
{
    use HasFactory;

    protected $table = 'casnos_pm';

    protected $fillable = [
        'casnos_id',
        'date_paiement',
        'matricule',
        'montant_versse',
        'montant_enkissi',
        'reference',
        'description',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant_versse' => 'decimal:2',
        'montant_enkissi' => 'decimal:2',
    ];

    public function casnos()
    {
        return $this->belongsTo(Casnos::class, 'casnos_id');
    }
}