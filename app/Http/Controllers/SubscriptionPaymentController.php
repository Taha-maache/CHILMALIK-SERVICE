<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionPaymentController extends Controller
{
    public function index(Subscription $subscription)
    {
        // نجيب آخر تجديد، إذا كان موجودًا.
    /** @var \App\Models\SubscriptionRenewal|null $latestRenewal */
$latestRenewal = $subscription->renewals()
    ->orderByDesc('id')
    ->first();
    
        if ($latestRenewal) {
            // دفعات آخر تجديد فقط.
                $payments = $latestRenewal->payments()
                ->orderByDesc('payment_date')
                ->orderByDesc('id')
                ->get();

            $totalAmount = (float) $latestRenewal->amount;
        } else {
            // إذا ما كان حتى تجديد، نعرض دفعات الاشتراك الأصلي فقط.
            $payments = $subscription->payments()
                ->whereNull('renewal_id')
                ->orderByDesc('payment_date')
                ->orderByDesc('id')
                ->get();

            $totalAmount = (float) ($subscription->total_amount ?? 10000);
        }

        // نخلي الواجهة الحالية تستعمل الدفعات الصحيحة.
        $subscription->setRelation('payments', $payments);

        $totalPaid = (float) $payments->sum('amount');
        $remaining = max(0, $totalAmount - $totalPaid);

        return view('subscriptions.payments.index', compact(
            'subscription',
            'payments',
            'latestRenewal',
            'totalAmount',
            'totalPaid',
            'remaining'
        ));
    }

    public function store(Request $request, Subscription $subscription)
    {
        
        
        $validated = $request->validate([
            'amount' => 'required|numeric|gt:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($subscription, $validated) {

            // نقفل الاشتراك أثناء الحساب والتسجيل.
            $lockedSubscription = Subscription::whereKey($subscription->id)
                ->lockForUpdate()
                ->firstOrFail();

            // نحدد التجديد الحالي.
            $latestRenewal = $lockedSubscription->renewals()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($latestRenewal) {
                // حساب دفعات هذا التجديد وحده.
                $totalAmount = (float) $latestRenewal->amount;
                
        /** @var \App\Models\SubscriptionRenewal|null $latestRenewal */
$latestRenewal = $lockedSubscription->renewals()
    ->orderByDesc('id')
    ->lockForUpdate()
    ->first();        

                $totalPaid = (float) $latestRenewal->payments()
                    ->sum('amount');

                $remaining = max(0, $totalAmount - $totalPaid);

                if ((float) $validated['amount'] > $remaining) {
                    throw ValidationException::withMessages([
                        'amount' => 'المبلغ أكبر من المبلغ المتبقي: '
                            . number_format($remaining, 2, ',', ' ')
                            . ' DA',
                    ]);
                }

                // ربط الدفعة بالاشتراك والتجديد الحالي.
                SubscriptionPayment::create([
                    'subscription_id' => $lockedSubscription->id,
                    'renewal_id' => $latestRenewal->id,
                    'amount' => $validated['amount'],
                    'payment_date' => $validated['payment_date'],
                    'notes' => $validated['notes'] ?? null,
                ]);
            } else {
                // ما كاينش تجديد: نسجل الدفعة للاشتراك الأصلي.
                $totalAmount = (float) (
                    $lockedSubscription->total_amount ?? 10000
                );

                $totalPaid = (float) $lockedSubscription->payments()
                    ->whereNull('renewal_id')
                    ->sum('amount');

                $remaining = max(0, $totalAmount - $totalPaid);

                if ((float) $validated['amount'] > $remaining) {
                    throw ValidationException::withMessages([
                        'amount' => 'المبلغ أكبر من المبلغ المتبقي: '
                            . number_format($remaining, 2, ',', ' ')
                            . ' DA',
                    ]);
                }

                SubscriptionPayment::create([
                    'subscription_id' => $lockedSubscription->id,
                    'renewal_id' => null,
                    'amount' => $validated['amount'],
                    'payment_date' => $validated['payment_date'],
                    'notes' => $validated['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('subscriptions.invoice', $subscription->id)
            ->with('success', 'تم تسجيل الدفعة بنجاح.');
    }
}
