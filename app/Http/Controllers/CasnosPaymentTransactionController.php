<?php

namespace App\Http\Controllers;

use App\Models\CasnosPayment;
use App\Models\CasnosPaymentTransaction;
use Illuminate\Http\Request;

class CasnosPaymentTransactionController extends Controller
{
    /**
     * عرض دفعات Client معين
     */
  public function index($casnosPaymentId)
{
    $casnosPayment = CasnosPayment::with('trader')
        ->findOrFail($casnosPaymentId);

    $transactions = $casnosPayment->transactions()
        ->latest('payment_date')
        ->paginate(10);

    return view(
        'casnosPayment.transactions.index',
        compact('casnosPayment', 'transactions')
    );
}


    /**
     * صفحة إضافة دفعة
     */
public function create($casnosPaymentId)
{
    $casnosPayment = CasnosPayment::with('trader')
        ->findOrFail($casnosPaymentId);

    return view(
        'casnosPayment.transactions.create',
        compact('casnosPayment')
    );
}
    /**
     * حفظ الدفعة
     */
    public function store(Request $request, $casnosPaymentId)
    {
        $casnosPayment = CasnosPayment::findOrFail($casnosPaymentId);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['casnos_payment_id'] = $casnosPayment->id;

        $transaction = CasnosPaymentTransaction::create($validated);

        /*
        |--------------------------------------------------------------------------
        | تحديث montant_versse
        |--------------------------------------------------------------------------
        */

        $totalPaid = $casnosPayment->transactions()->sum('amount');

        $casnosPayment->montant_versse = $totalPaid;

        $casnosPayment->save();

        return redirect()
            ->route(
                'casnos-payments.transactions.index',
                $casnosPayment->id
            )
            ->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * صفحة تعديل دفعة
     */
 public function edit($id)
{
    $transaction = CasnosPaymentTransaction::with('casnosPayment.trader')
        ->findOrFail($id);

    $casnosPayment = $transaction->casnosPayment;

    return view(
        'casnosPayment.transactions.edit',
        compact('transaction', 'casnosPayment')
    );
}
    /**
     * تحديث الدفعة
     */
    public function update(Request $request, $id)
    {
        $transaction = CasnosPaymentTransaction::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);

        /*
        |--------------------------------------------------------------------------
        | إعادة حساب المبلغ المدفوع
        |--------------------------------------------------------------------------
        */

        $casnosPayment = $transaction->casnosPayment;

        $totalPaid = $casnosPayment->transactions()->sum('amount');

        $casnosPayment->montant_versse = $totalPaid;

        $casnosPayment->save();

        return redirect()
            ->route(
                'casnos-payments.transactions.index',
                $casnosPayment->id
            )
            ->with('success', 'Paiement modifié avec succès.');
    }

    /**
     * حذف الدفعة
     */
    public function destroy($id)
    {
        $transaction = CasnosPaymentTransaction::findOrFail($id);

        $casnosPayment = $transaction->casnosPayment;

        $transaction->delete();

        /*
        |--------------------------------------------------------------------------
        | إعادة حساب montant_versse بعد الحذف
        |--------------------------------------------------------------------------
        */

        $totalPaid = $casnosPayment->transactions()->sum('amount');

        $casnosPayment->montant_versse = $totalPaid;

        $casnosPayment->save();

        return redirect()
            ->route(
                'casnos-payments.transactions.index',
                $casnosPayment->id
            )
            ->with('success', 'Paiement supprimé avec succès.');
    }

public function facture($id)
{
    $transaction = CasnosPaymentTransaction::with('casnosPayment.trader')
        ->findOrFail($id);

    $casnosPayment = $transaction->casnosPayment;

    $transactions = $casnosPayment->transactions()
        ->orderBy('payment_date', 'asc')
        ->get();

    // الحسابات الموحدة من Model
    $montantOriginal = (float) $casnosPayment->montant_enkissi;

    $montantPaye = (float) $casnosPayment->montant_versse;

    $resteInitial = $casnosPayment->getOriginalRemaining();

    $nombreMois = $casnosPayment->getMonthsLate();

    $tauxAugmentation = $casnosPayment->getPenaltyRate();

    $augmentation = $casnosPayment->getPenaltyAmount();

    $resteAPayer = $casnosPayment->getAdjustedBalance();

    $montantDu = $casnosPayment->getAdjustedDue();

    $excedent = max(0, $montantPaye - $montantOriginal);

    $status = $resteAPayer <= 0 ? 'SOLDE' : 'RESTE À PAYER';

    $totalTransactions = $transactions->sum('amount');

    $html = view(
        'casnosPayment.transactions.facture',
        compact(
            'transaction',
            'casnosPayment',
            'transactions',
            'montantOriginal',
            'montantPaye',
            'resteInitial',
            'nombreMois',
            'tauxAugmentation',
            'augmentation',
            'resteAPayer',
            'montantDu',
            'excedent',
            'status',
            'totalTransactions'
        )
    )->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 15,
        'margin_bottom' => 15,
        'margin_left' => 15,
        'margin_right' => 15,
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output(
            'facture-casnos-paiement-' . $transaction->id . '.pdf',
            'S'
        )
    )->header('Content-Type', 'application/pdf');
}

}