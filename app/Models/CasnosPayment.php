<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class CasnosPayment extends Model
{
    

    protected $fillable = [
        'trader_id',
        'date_paiement',
        'matricule',
        'pay_type',
        'montant_versse',
        'montant_enkissi',
        'username',
        'password',
        'carte_chifa',
        'recours',
        'recours_date',
    ];
  protected $casts = [
        'date_paiement' => 'date',
        'montant_versse' => 'decimal:2',
        'montant_enkissi' => 'decimal:2',
        'recours' => 'boolean',
        'recours_date' => 'date',
        'last_whatsapp_reminder_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(
            CasnosPaymentTransaction::class,
            'casnos_payment_id'
        );
    }
    // relation
    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
public function recoursExpired()
{
    if (!$this->recours || !$this->recours_date) {
        return false;
    }

    return \Carbon\Carbon::parse($this->recours_date)
        ->addDays(3)
        ->isPast();
}
/**
 * عدد الأشهر الكاملة منذ تاريخ الدفع.
 */

/**
 * عدد أشهر التأخير:
 * كل 30 يوم كامل = شهر.
 */
public function getMonthsLate()
{
    if (!$this->date_paiement) {
        return 0;
    }

    $datePaiement = Carbon::parse($this->date_paiement)->startOfDay();
    $today = Carbon::today();

    if ($datePaiement->greaterThanOrEqualTo($today)) {
        return 0;
    }

    $daysLate = $datePaiement->diffInDays($today);

    return intdiv($daysLate, 30);
}

/**
 * أول شهر 10%، وكل شهر إضافي 1%.
 * غير تراكمي.
 */
public function getPenaltyRate()
{
    $monthsLate = $this->getMonthsLate();

    if ($monthsLate <= 0) {
        return 0;
    }

    return 10 + ($monthsLate - 1);
}

/**
 * أصل المبلغ المتبقي قبل الزيادة.
 */
public function getOriginalRemaining()
{
    $due = (float) $this->montant_enkissi;
    $paid = (float) $this->montant_versse;

    return round(max(0, $due - $paid), 2);
}

/**
 * حساب الزيادة على المبلغ المتبقي فقط.
 */
public function getPenaltyAmount()
{
    $remaining = $this->getOriginalRemaining();

    if ($remaining <= 0) {
        return 0;
    }

    $rate = $this->getPenaltyRate();

    return round($remaining * ($rate / 100), 2);
}

/**
 * المبلغ المتبقي بعد الزيادة.
 */
public function getAdjustedBalance()
{
    return round(
        $this->getOriginalRemaining() + $this->getPenaltyAmount(),
        2
    );
}

/**
 * مجموع المستحقات بعد الزيادة مع ما تم دفعه.
 */
public function getAdjustedDue()
{
    return round(
        (float) $this->montant_versse + $this->getAdjustedBalance(),
        2
    );
}

/**
 * المتبقي النهائي بعد الزيادة.
 */
public function getRemainingAmount()
{
    return $this->getAdjustedBalance();
}

}