<?php

namespace App\Http\Controllers;

use App\Models\Casnos;
use App\Models\CasnosPm;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
class CasnosPmController extends Controller
{
    /**
     * عرض جميع paiements تاع client
     */
    public function index($casnosId)
    {
        $casnos = Casnos::findOrFail($casnosId);

        $payments = $casnos->payments()
            ->orderBy('date_paiement', 'desc')
            ->get();

        return view('casnos.pm.index', compact('casnos', 'payments'));
    }

    /**
     * صفحة إضافة paiement
     */
    public function create($casnosId)
    {
        $casnos = Casnos::findOrFail($casnosId);

        return view('casnos.pm.create', compact('casnos'));
    }

    /**
     * تسجيل paiement
     */
public function store(Request $request, $casnosId)
{
    $casnos = Casnos::findOrFail($casnosId);

    $request->validate([
        'date_paiement' => 'required|date',
        'montant_versse' => 'required|numeric|min:0.01',
        'reference' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $montant = (float) $request->montant_versse;

    // المجموع القديم للدفعات
    $totalBefore = $casnos->payments()->sum('montant_versse');

    // المجموع بعد الدفع الجديد
    $totalAfter = $totalBefore + $montant;

    // الباقي في الـPM يظهر موجب
    // إذا خلص أكثر من المطلوب => 0
    $restePayment = max(
        0,
        (float) $casnos->montant_enkissi - $totalAfter
    );

    // تسجيل paiement
    $casnos->payments()->create([
        'date_paiement' => $request->date_paiement,
        'matricule' => $casnos->matricule,
        'montant_versse' => $montant,
        'montant_rest' => $restePayment,
        'reference' => $request->reference,
        'description' => $request->description,
    ]);

    // تحديث مجموع ما دفعه client
    $casnos->montant_versse = $totalAfter;

    // montant_rest تاع CASNOS يتحسب وحدو
    // montant_versse - montant_enkissi
    // مثال: 3500 - 3000 = +500
    $casnos->save();

    return redirect()
        ->route('casnos.pm.index', $casnos->id)
        ->with('success', 'Paiement ajouté avec succès.');
}

public function edit($casnosId, $paymentId)
{
    $payment = CasnosPm::findOrFail($paymentId);

    $casnos = Casnos::findOrFail($casnosId);

    return view('casnos.pm.edit', compact('payment', 'casnos'));
}

public function update(Request $request, $casnosId, $paymentId)
{ 
       

    $payment = CasnosPm::findOrFail($paymentId);
    $casnos = Casnos::findOrFail($casnosId);

    $request->validate([
        'date_paiement' => 'required|date',
        'montant_versse' => 'required|numeric|min:0.01',
        'reference' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $newAmount = (float) $request->montant_versse;

    // مجموع payments الآخرين
    $otherPayments = $casnos->payments()
        ->where('id', '!=', $payment->id)
        ->sum('montant_versse');

    $maxAllowed = max(
        0,
        $casnos->montant_enkissi - $otherPayments
    );

    if ($newAmount > $maxAllowed) {
        return back()
            ->withInput()
            ->withErrors([
                'montant_versse' =>
                    'Le montant dépasse le montant restant.'
            ]);
    }

    $payment->update([
        'date_paiement' => $request->date_paiement,
        'montant_versse' => $newAmount,
        'reference' => $request->reference,
        'description' => $request->description,
    ]);

    // إعادة حساب المجموع
    $casnos->montant_versse =
        $casnos->payments()->sum('montant_versse');

    // montant_rest ما نلمسوهش
    $casnos->save();

    return redirect()
        ->route('casnos.pm.index', $casnos->id)
        ->with('success', 'Paiement modifié avec succès.');
}


    /**
     * حذف paiement
     */
public function destroy($id)
{
    $payment = CasnosPm::findOrFail($id);

    $casnos = $payment->casnos;

    $payment->delete();

    // إعادة حساب مجموع payments
    $casnos->montant_versse =
        $casnos->payments()->sum('montant_versse');

    // montant_rest يتحسب وحدو
    $casnos->save();

    return back()->with(
        'success',
        'Paiement supprimé avec succès.'
    );
}

 public function facture($id)
{
    $payment = CasnosPm::with('casnos')->findOrFail($id);

    $casnos = $payment->casnos;

    $payments = $casnos->payments()
        ->orderBy('date_paiement', 'asc')
        ->get();

    // نحضرو HTML تاع الفاتورة
    $html = view('casnos.pm.facture', compact(
        'payment',
        'casnos',
        'payments'
    ))->render();

    // إنشاء PDF
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'autoArabic' => true,
        'autoLangToFont' => true,
        'autoScriptToLang' => true,
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output(
            'facture-casnos-pm-' . $payment->id . '.pdf',
            'I'
        )
    )->header('Content-Type', 'application/pdf');
}

}