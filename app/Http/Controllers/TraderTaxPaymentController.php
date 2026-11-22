<?php

namespace App\Http\Controllers;
use Mpdf\Mpdf;
use App\Models\TraderTax;
use App\Models\TraderTaxPayment;
use Illuminate\Http\Request;

class TraderTaxPaymentController extends Controller
{
    /**
     * عرض جميع الدفعات الخاصة بـ Tax معين
     */
    public function index($traderTaxId)
    {
        $traderTax = TraderTax::with('trader')
            ->findOrFail($traderTaxId);

        $payments = $traderTax->payments()
            ->latest('payment_date')
            ->get();

        $totalDue = (float) $traderTax->amount;

        $totalPaid = (float) $payments->sum('amount');

        $remaining = max(0, $totalDue - $totalPaid);

        $overpaid = max(0, $totalPaid - $totalDue);

        return view(
            'trader_taxes.payments.index',
            compact(
                'traderTax',
                'payments',
                'totalDue',
                'totalPaid',
                'remaining',
                'overpaid'
            )
        );
    }

    /**
     * Formulaire Ajouter paiement
     */
    public function create($traderTaxId)
    {
        $traderTax = TraderTax::with('trader')
            ->findOrFail($traderTaxId);

        return view(
            'trader_taxes.payments.create',
            compact('traderTax')
        );
    }

    /**
     * Enregistrer paiement
     */
    public function store(Request $request, $traderTaxId)
    {
        $traderTax = TraderTax::findOrFail($traderTaxId);

        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        TraderTaxPayment::create([
            'trader_tax_id' => $traderTax->id,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('trader-tax-payments.index', $traderTax->id)
            ->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Formulaire Modifier
     */
    public function edit($id)
    {
        $payment = TraderTaxPayment::with('traderTax.trader')
            ->findOrFail($id);

        return view(
            'trader_taxes.payments.edit',
            compact('payment')
        );
    }

    /**
     * Modifier paiement
     */
    public function update(Request $request, $id)
    {
        $payment = TraderTaxPayment::findOrFail($id);

        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $payment->update([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'description' => $request->description,
        ]);

        return redirect()
            ->route(
                'trader-tax-payments.index',
                $payment->trader_tax_id
            )
            ->with('success', 'Paiement modifié avec succès.');
    }

    /**
     * Supprimer paiement
     */
    public function destroy($id)
    {
        $payment = TraderTaxPayment::findOrFail($id);

        $traderTaxId = $payment->trader_tax_id;

        $payment->delete();

        return redirect()
            ->route(
                'trader-tax-payments.index',
                $traderTaxId
            )
            ->with('success', 'Paiement supprimé avec succès.');
    }
public function facture($id)
{
    // paiement الحالي
    $payment = TraderTaxPayment::with('traderTax.trader')
        ->findOrFail($id);

    // Tax المرتبط
    $traderTax = $payment->traderTax;

    // جميع paiements لهذا Tax
    $payments = $traderTax->payments()
        ->latest('payment_date')
        ->get();

    // الحسابات
    $totalDue = (float) $traderTax->amount;

    $totalPaid = (float) $payments->sum('amount');

    $remaining = max(0, $totalDue - $totalPaid);

    $overpaid = max(0, $totalPaid - $totalDue);

    // HTML تاع facture
    $html = view(
        'trader_taxes.payments.facture',
        compact(
            'payment',
            'traderTax',
            'payments',
            'totalDue',
            'totalPaid',
            'remaining',
            'overpaid'
        )
    )->render();

    // mPDF
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'P',
        'default_font' => 'dejavusans',
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output(
            'facture-paiement-tax-' . $payment->id . '.pdf',
            'S'
        )
    )
    ->header('Content-Type', 'application/pdf')
    ->header(
        'Content-Disposition',
        'inline; filename="facture-paiement-tax-' . $payment->id . '.pdf"'
    );
}

}