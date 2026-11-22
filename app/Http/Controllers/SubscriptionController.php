<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

$subscriptions = $query
    ->with('payments')
    ->latest()
    ->paginate(500);

        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | نشوف إذا هذا الرقم راه موجود من قبل
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::where('phone', $request->phone)->first();

        /*
        |--------------------------------------------------------------------------
        | إذا الشخص موجود:
        | نحدث نفس الاشتراك = تجديد
        |--------------------------------------------------------------------------
        */

        if ($subscription) {

            $subscription->update([
                'full_name' => $request->full_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'active',
                'total_amount' => 5000,
            ]);

            return redirect()
                ->route('subscriptions.index')
                ->with('success', 'تم تجديد الاشتراك بنجاح ✅');
        }

        /*
        |--------------------------------------------------------------------------
        | إذا ماكانش موجود:
        | اشتراك جديد
        |--------------------------------------------------------------------------
        */

        Subscription::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
               'total_amount' => 10000,
        ]);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'تم إنشاء الاشتراك بنجاح ✅');
    }

    /*
    |--------------------------------------------------------------------------
    | تجديد مباشر بدون إعادة إدخال المعلومات
    |--------------------------------------------------------------------------
    */

    public function renew(Subscription $subscription)
    {
        return view('subscriptions.renew', compact('subscription'));
    }


public function processRenew(Request $request, Subscription $subscription)
{
    $validated = $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $renewal = \Illuminate\Support\Facades\DB::transaction(function () use (
        $subscription,
        $validated
    ) {
        $locked = Subscription::whereKey($subscription->id)
            ->lockForUpdate()
            ->firstOrFail();

        $renewal = $locked->renewals()->create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'amount' => 5000,
        ]);

        $locked->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'active',
        ]);

        return $renewal;
    });

    return redirect()
        ->route('subscriptions.invoice', $subscription->id)
        ->with('success', 'تم التجديد وإنشاء فاتورة جديدة رقم #' . $renewal->id);
}

    public function edit(Subscription $subscription)
    {
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($request->all());

        return redirect()->route('subscriptions.index');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return back();
    }

    

public function invoice(Subscription $subscription)
{
    $subscription->load([
        'renewals' => fn ($query) => $query
            ->orderByDesc('id')
            ->with(['payments' => fn ($payments) => $payments
                ->orderBy('payment_date')
                ->orderBy('id')]),
    ]);

    $latestRenewal = $subscription->renewals->first();

    if ($latestRenewal) {
        $payments = $latestRenewal->payments;
        $amount = (float) $latestRenewal->amount;
        $totalPaid = (float) $payments->sum('amount');
        $remaining = max(0, $amount - $totalPaid);

        $subscription->start_date = $latestRenewal->start_date;
        $subscription->end_date = $latestRenewal->end_date;

        $type = 'فاتورة تجديد رقم #' . $latestRenewal->id;
        $invoiceNumber = 'REN-' . $latestRenewal->id;
    } else {
        $payments = $subscription->payments()
            ->whereNull('renewal_id')
            ->orderBy('payment_date')
            ->orderBy('id')
            ->get();

        $amount = (float) ($subscription->total_amount ?? 10000);
        $totalPaid = (float) $payments->sum('amount');
        $remaining = max(0, $amount - $totalPaid);

        $type = 'فاتورة الاشتراك الأصلي';
        $invoiceNumber = 'SUB-' . $subscription->id;
    }

    $type .= $remaining <= 0.001
        ? ' - مدفوع بالكامل'
        : ($totalPaid > 0 ? ' - دفع جزئي' : ' - غير مدفوع');

    $html = view('subscriptions.invoice', compact(
        'subscription',
        'payments',
        'amount',
        'type',
        'totalPaid',
        'remaining',
        'invoiceNumber'
    ))->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'P',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'default_font' => 'dejavusans',
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
    ]);

    $mpdf->SetDirectionality('rtl');
    $mpdf->WriteHTML($html);

    return response($mpdf->Output(
        'subscription-invoice-' . $subscription->id . '.pdf',
        'S'
    ))
        ->header('Content-Type', 'application/pdf')
        ->header(
            'Content-Disposition',
            'inline; filename="subscription-invoice-' . $subscription->id . '.pdf"'
        );
}

}
