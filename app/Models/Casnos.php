<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Casnos extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'phone', 'date_paiement',
        'matricule', 'pay_type', 'montant_versse',
        'montant_enkissi', 'username', 'password',
        'carte_chifa', 'address', 'recours', 'recours_date',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'recours_date' => 'date',
        'montant_versse' => 'decimal:2',
        'montant_enkissi' => 'decimal:2',
        'last_whatsapp_reminder_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(CasnosPm::class, 'casnos_id');
    }

    public function getMonthsLate(): int
    {
        if (!$this->date_paiement) {
            return 0;
        }

        $date = Carbon::parse($this->date_paiement)->startOfDay();
        $today = Carbon::today();

        if ($date->greaterThanOrEqualTo($today)) {
            return 0;
        }

        return (int) $date->diffInMonths($today);
    }

    // Reste initial, sans majoration
    public function getOriginalRemaining(): float
    {
        return max(
            0,
            (float) $this->montant_enkissi
                - (float) $this->montant_versse
        );
    }

    // 5 % par mois complet, sans capitalisation
    public function getPenaltyRate(): float
    {
        if ($this->getOriginalRemaining() <= 0) {
            return 0;
        }
        if ($this->getMonthsLate() <= 0) {
            return 0;
        }

        return 10 + ($this->getMonthsLate() - 1);
    }

    // Majoration sur le reste impayé seulement
    public function getPenaltyAmount(): float
    {
        $reste = $this->getOriginalRemaining();

        if ($reste <= 0) {
            return 0;
        }

        return round(
            $reste * $this->getPenaltyRate() / 100,
            2
        );
    }

    // Montant total dû, majoration comprise
    public function getAdjustedDue(): float
    {
        if ($this->getOriginalRemaining() <= 0) {
            return (float) $this->montant_enkissi;
        }

        return round(
            (float) $this->montant_enkissi
                + $this->getPenaltyAmount(),
            2
        );
    }

    // Négatif = dette, positif = excédent
    public function getAdjustedBalance(): float
    {
        return round(
            (float) $this->montant_versse
                - $this->getAdjustedDue(),
            2
        );
    }

    public function getAdjustedRemaining(): float
    {
        return max(0, -$this->getAdjustedBalance());
    }

    public function recoursExpired(): bool
    {
        if (!$this->recours || !$this->recours_date) {
            return false;
        }

        return Carbon::parse($this->recours_date)
            ->addDays(3)
            ->isPast();
    }
}
