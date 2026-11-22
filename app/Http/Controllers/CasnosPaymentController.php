<?php

namespace App\Http\Controllers;

use App\Models\CasnosPayment;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\CasnosPaymentTransaction;
use Carbon\Carbon;
class CasnosPaymentController extends Controller
{
    // 📄 عرض كل الداتا

public function index(Request $request)
{
    $payments = CasnosPayment::with('trader');

    if ($request->search) {

        $search = $request->search;

        $payments->whereHas('trader', function ($q) use ($search) {

            $q->where('nin', 'like', "%$search%")
              ->orWhere('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhereRaw(
                  "CONCAT(first_name, ' ', last_name) LIKE ?",
                  ["%$search%"]
              )
              ->orWhere('matricule', 'like', "%$search%");
        });
    }

    $payments = $payments->latest()->get();

    foreach ($payments as $p) {

        $p->original_remaining = $p->getOriginalRemaining();

        $p->months_late = $p->getMonthsLate();

        $p->penalty_rate = $p->getPenaltyRate();

        $p->penalty_amount = $p->getPenaltyAmount();

        $p->adjusted_balance = $p->getAdjustedBalance();

        if ($p->original_remaining > 0) {

            // الدين بالسالب
            $p->balance = -$p->adjusted_balance;

        } else {

            // الفائض بالموجب
            $p->balance = round(
                (float) $p->montant_versse -
                (float) $p->montant_enkissi,
                2
            );
        }
    }

    $count_creditors = $payments
        ->where('balance', '<', 0)
        ->count();

    $count_debtors = $payments
        ->where('balance', '>', 0)
        ->count();

    if ($request->ajax()) {
        return view(
            'casnosPayment.index',
            compact('payments', 'count_creditors', 'count_debtors')
        )->render();
    }

    return view(
        'casnosPayment.index',
        compact('payments', 'count_creditors', 'count_debtors')
    );
}


    // ➕ فورم + البحث بـ NIN
 public function create(Request $request)
{
    $traders = Trader::query();

    if ($request->search) {
        $search = $request->search;

        $traders->where(function ($q) use ($search) {
            $q->where('nin', 'like', "%{$search}%")
              ->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('matricule', 'like', "%{$search}%");
        });
    }

    return view('casnosPayment.create', [
        'traders' => $traders->paginate(60)
    ]);
}


    // 💾 الحفظ
    public function store(Request $request)
{
    $request->validate([
        'trader_id' => 'required|exists:traders,id',
        'date_paiement' => 'required|date',
        'matricule' => 'required',
        'pay_type' => 'required',
        'montant_versse' => 'required|numeric|min:0',
        'montant_enkissi' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {

        // 1️⃣ إنشاء CASNOS Payment
        $payment = CasnosPayment::create([
            'trader_id' => $request->trader_id,
            'date_paiement' => $request->date_paiement,
            'matricule' => $request->matricule,
            'pay_type' => $request->pay_type,

            'montant_versse' => $request->montant_versse,
            'montant_enkissi' => $request->montant_enkissi,

            'username' => $request->username,
            'password' => $request->password,
            'carte_chifa' => $request->carte_chifa,
            'recours' => $request->recours,
            'recours_date' => $request->recours_date,

        ]);

        // 2️⃣ إنشاء أول Transaction تلقائياً
        if ($request->montant_versse > 0) {

            CasnosPaymentTransaction::create([
                'casnos_payment_id' => $payment->id,

                // أول دفعة = montant_versse
                'amount' => $request->montant_versse,

                // تاريخ أول دفعة
                'payment_date' => $request->date_paiement,

                'reference' => '1',
            ]);
        }
    });

    return redirect()
        ->route('casnos-payments.index')
        ->with('success', 'CASNOS Payment ajouté avec succès');
}

    // ✏️ edit
 public function edit($id)
{
    
    $payment = CasnosPayment::findOrFail($id);

    $traders = Trader::all();



    return view('casnosPayment.edit', compact('payment', 'traders'));
}
    // 🔄 update
    public function update(Request $request, $id)
    {
        $payment = CasnosPayment::findOrFail($id);

        $payment->update([
            'date_paiement' => $request->date_paiement,
            'matricule' => $request->matricule,
            'pay_type' => $request->pay_type,
            'montant_versse' => $request->montant_versse,
            'montant_enkissi' => $request->montant_enkissi,
            'username' => $request->username,
            'password' => $request->password,
            'carte_chifa' => $request->carte_chifa,
            'recours' => $request->recours,
            'recours_date' => $request->recours_date,


        ]);

        return redirect()->route('casnos-payments.index')
            ->with('success', 'تم التحديث');
    }

    // 🗑️ delete
    public function destroy($id)
    {
        $payment = CasnosPayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('casnos-payments.index')
            ->with('success', 'تم الحذف');
    }

    // 👁️ show (اختياري)
    public function show($id)
    {
        $payment = CasnosPayment::with('trader')->findOrFail($id);
        return view('casnosPayment.show', compact('payment'));
    }
 


public function creditors()
{
    $payments = CasnosPayment::with('trader')->get();

    foreach ($payments as $p) {

        $p->months_late = $p->getMonthsLate();

        $p->penalty_rate = $p->getPenaltyRate();

        $p->original_remaining = $p->getOriginalRemaining();

        $p->penalty_amount = $p->getPenaltyAmount();

        $p->adjusted_balance = $p->getAdjustedBalance();

        $p->balance = -$p->adjusted_balance;
    }

    $payments = $payments
        ->filter(function ($p) {
            return $p->original_remaining > 0;
        })
        ->values();

    return view('casnosPayment.creditors', compact('payments'));
}



public function overpaid()
{
    $payments = CasnosPayment::with('trader')->get();

    foreach ($payments as $p) {

        $p->months_late = $p->getMonthsLate();

        $p->penalty_rate = $p->getPenaltyRate();

        $p->penalty_amount = $p->getPenaltyAmount();

        $p->adjusted_due = $p->getAdjustedDue();

        $p->original_remaining = $p->getOriginalRemaining();

        $p->balance = round(
            (float) $p->montant_versse -
            (float) $p->montant_enkissi,
            2
        );

        $p->remaining_amount = 0;
    }

    $payments = $payments
        ->filter(function ($p) {
            return $p->balance > 0;
        })
        ->values();

    return view('casnosPayment.overpaid', compact('payments'));
}


public function searchTraders(Request $request)
{
    $search = trim($request->input('search', ''));

    if ($search === '') {
        return response()->json([]);
    }

    $traders = Trader::query()
        ->where(function ($query) use ($search) {
            $query->where('NIN', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw(
                      "CONCAT(first_name, ' ', last_name) LIKE ?",
                      ["%{$search}%"]
                  );
        })
        ->select('id', 'NIN', 'first_name', 'last_name')
        ->limit(20)
        ->get();

    return response()->json($traders);
}
// صفحة تذكير CASNOS عبر WhatsApp
public function whatsappReminder($id)
{
    $payment = CasnosPayment::with('trader')->findOrFail($id);

    $remaining = $payment->getAdjustedBalance();

    // التحقق من وجود دين
    if ($payment->getOriginalRemaining() <= 0 || $remaining <= 0) {
        return redirect()
            ->route('casnos-payments.index')
            ->with('error', 'لا يوجد مبلغ متبقٍ يستوجب التذكير.');
    }

    // التحقق من مرور 25 يوماً
    if (Carbon::parse($payment->date_paiement)->addDays(25)->isFuture()) {
        return redirect()
            ->route('casnos-payments.index')
            ->with('error', 'لم يحن موعد التذكير بعد.');
    }

    // التحقق من مرور 3 أيام على آخر تذكير
    if (
        $payment->last_whatsapp_reminder_at &&
        Carbon::parse($payment->last_whatsapp_reminder_at)->addDays(3)->isFuture()
    ) {
        return redirect()
            ->route('casnos-payments.index')
            ->with('error', 'تم إرسال تذكير مؤخراً.');
    }

    $phone = $payment->trader->phone ?? '';

    return view('casnosPayment.whatsapp', compact(
        'payment',
        'remaining',
        'phone'
    ));
}


// تسجيل إرسال التذكير
public function markWhatsappReminderSent($id)
{
    $payment = CasnosPayment::with('trader')->findOrFail($id);

    $remaining = $payment->getAdjustedBalance();

    if (
        $payment->getOriginalRemaining() <= 0 ||
        $remaining <= 0 ||
        Carbon::parse($payment->date_paiement)->addDays(25)->isFuture() ||
        (
            $payment->last_whatsapp_reminder_at &&
            Carbon::parse($payment->last_whatsapp_reminder_at)
                ->addDays(3)->isFuture()
        )
    ) {
        return response()->json([
            'success' => false,
            'message' => 'التذكير غير متاح حالياً.'
        ], 422);
    }

    $payment->last_whatsapp_reminder_at = now();
    $payment->save();

    return response()->json([
        'success' => true
    ]);
}
}