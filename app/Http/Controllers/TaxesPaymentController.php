<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\TaxesPayment;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
 
class TaxesPaymentController extends Controller
{
    /**
     * عرض جميع الدفعات الخاصة بـ Tax
     */
    public function index($taxId)
    {
        $tax = Tax::findOrFail($taxId);

        $payments = $tax->payments()
            ->latest('payment_date')
            ->get();

        // المبلغ الأصلي المستحق
        $totalDue = (float) $tax->amount;

        // مجموع الدفعات
        $totalPaid = (float) $payments->sum('amount');

        // الباقي
        $remaining = max(0, $totalDue - $totalPaid);

        // المبلغ الزائد
        $overpaid = max(0, $totalPaid - $totalDue);

        return view(
            'taxes.payments.index',
            compact(
                'tax',
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
    public function create($taxId)
    {
        $tax = Tax::findOrFail($taxId);

        return view(
            'taxes.payments.create',
            compact('tax')
        );
    }

    /**
     * Enregistrer paiement
     */
    public function store(Request $request, $taxId)
    {
        $tax = Tax::findOrFail($taxId);

        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        TaxesPayment::create([
            'tax_id' => $tax->id,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('tax-payments.index', $tax->id)
            ->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Formulaire Modifier
     */
    public function edit($id)
    {
        $payment = TaxesPayment::with('tax')
            ->findOrFail($id);

        return view(
            'taxes.payments.edit',
            compact('payment')
        );
    }

    /**
     * Modifier paiement
     */
    public function update(Request $request, $id)
    {
        $payment = TaxesPayment::findOrFail($id);

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
                'tax-payments.index',
                $payment->tax_id
            )
            ->with('success', 'Paiement modifié avec succès.');
    }

    /**
     * Supprimer paiement
     */
    public function destroy($id)
    {
        $payment = TaxesPayment::findOrFail($id);

        $taxId = $payment->tax_id;

        $payment->delete();

        return redirect()
            ->route(
                'tax-payments.index',
                $taxId
            )
            ->with('success', 'Paiement supprimé avec succès.');
    }
    public function facture($id)
{
    $payment = TaxesPayment::with('tax')
        ->findOrFail($id);

    $tax = $payment->tax;

    $payments = $tax->payments()
        ->latest('payment_date')
        ->get();

    $totalDue = (float) $tax->amount;

    $totalPaid = (float) $payments->sum('amount');

    $remaining = max(0, $totalDue - $totalPaid);

    $overpaid = max(0, $totalPaid - $totalDue);

    $html = view(
        'taxes.payments.facture',
        compact(
            'payment',
            'tax',
            'payments',
            'totalDue',
            'totalPaid',
            'remaining',
            'overpaid'
        )
    )->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 10,
        'margin_bottom' => 10,
        'margin_left' => 10,
        'margin_right' => 10,
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output(
            'tax-payment-' . $payment->id . '.pdf',
            'I'
        )
    )->header('Content-Type', 'application/pdf');
}
}