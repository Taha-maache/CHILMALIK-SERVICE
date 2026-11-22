<?php

namespace App\Http\Controllers;

use App\Models\Casnos;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class CasnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index(Request $request)
{
    $search = trim($request->input('search', ''));

    $clients = Casnos::when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('prenom', 'LIKE', "%{$search}%")
              ->orWhereRaw(
                  "CONCAT(nom, ' ', prenom) LIKE ?",
                  ["%{$search}%"]
              )
              ->orWhere('matricule', 'LIKE', "%{$search}%");
        });
    });

    $clients =  $clients->latest()->paginate(2000);

    foreach ($clients as $client) {
        $client->original_remaining = $client->getOriginalRemaining();
        $client->months_late = $client->getMonthsLate();
        $client->penalty_rate = $client->getPenaltyRate();
        $client->penalty_amount = $client->getPenaltyAmount();
        $client->adjusted_due = $client->getAdjustedDue();
        $client->adjusted_balance = $client->getAdjustedBalance();
        $client->adjusted_remaining = $client->getAdjustedRemaining();
    }

    // الإحصائيات على كامل القائمة، وليس الصفحة الحالية فقط
    $allClients = Casnos::all();

    $count_creditors = $allClients->filter(
        fn ($client) => $client->getAdjustedBalance() < 0
    )->count();

    $count_debtors = $allClients->filter(
        fn ($client) => $client->getAdjustedBalance() > 0
    )->count();
    
$casnosNotifications = $count_creditors + $count_debtors;

    return view('casnos.index', compact(
        'clients',
        'count_debtors',
        'count_creditors',
        'casnosNotifications'

    ));
}


public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'matricule' => 'required|string|max:255|unique:casnos,matricule',
        'pay_type' => 'required|string|max:255',
        'date_paiement' => 'nullable|date',

        'montant_versse' => 'required|numeric|min:0',
        'montant_enkissi' => 'required|numeric|min:0',

        'phone' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255',
        'carte_chifa' => 'nullable|boolean',
        'address' => 'nullable|string|max:255',

    ]);

    $montantEnkissi = (float) $request->montant_enkissi;
    $montantVersse = (float) $request->montant_versse;


    $casnos = Casnos::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'matricule' => $request->matricule,
        'pay_type' => $request->pay_type,
        'date_paiement' => $request->date_paiement,
        'recours' => $request->recours,
        'recours_date' => $request->recours_date,

        'montant_enkissi' => $montantEnkissi,
        'montant_versse' => $montantVersse,

        'phone' => $request->phone,
        'username' => $request->username,
        'password' => $request->password,
        'carte_chifa' => $request->boolean('carte_chifa'),
        'address' => $request->address,
    ]);

    // أول payment تلقائي
    if ($montantVersse > 0) {
        $casnos->payments()->create([
            'date_paiement' => $request->date_paiement ?? now()->toDateString(),
            'matricule' => $casnos->matricule,
            'montant_versse' => $montantVersse,
            'reference' => '1',
        ]);
    }

    return redirect()
        ->route('casnos.index')
        ->with('success', 'Client ajouté avec succès.');
}
 /**
     * Display the specified resource.
     */
    public function show(Casnos $casnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
// 1. باش تفتح الصفحة وتجيب البيانات
public function edit($id)
{
    $client = Casnos::findOrFail($id);
    return view('casnos.edit', compact('client'));
}

// 2. باش تسوفغاردي التعديلات في قاعدة البيانات
public function update(Request $request, $id)
{
    $client = Casnos::findOrFail($id);

    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'matricule' => 'required|string|max:255|unique:casnos,matricule,' . $id,
        'pay_type' => 'required|string|max:255',

        'date_paiement' => 'nullable|date',
        'montant_enkissi' => 'required|numeric|min:0',

        'phone' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255',
        'carte_chifa' => 'nullable|boolean',
        'address' => 'nullable|string|max:255',
    ]);

    $client->nom = $request->nom;
    $client->prenom = $request->prenom;
    $client->matricule = $request->matricule;
    $client->pay_type = $request->pay_type;
    $client->date_paiement = $request->date_paiement;

    $client->montant_enkissi = $request->montant_enkissi;

    $client->phone = $request->phone;
    $client->username = $request->username;
    $client->password = $request->password;
    $client->carte_chifa = $request->boolean('carte_chifa');
    $client->address = $request->address;
    $client->recours = $request->recours;
    $client->recours_date = $request->recours_date;

    // montant_versse = مجموع payments
    $client->montant_versse =
        $client->payments()->sum('montant_versse');

    // montant_rest ما نلمسوهش
    // MySQL يحسبه وحده

    $client->save();

    return redirect()
        ->route('casnos.index')
        ->with('success', 'تم تحديث البيانات بنجاح');
}
    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    // 1. نحوسو على الشخص
    $client = \App\Models\Casnos::findOrFail($id);
    
    // 2. نمسحوه
    $client->delete();

    // 3. نرجعو للقائمة مع رسالة نجاح
    return redirect()->route('casnos.index')->with('success', 'تم حذف البيانات بنجاح');
}// هادي هي اللي راهي ناقصة عندك
public function create()
{
    return view('casnos.create'); // تأكد بلي عندك ملف بهاد الاسم في resources/views/casnos/
}
// قائمة اللي يسالونا (عليهم دين)
// قائمة اللي يسالونا (عليهم دين)

// قائمة اللي نسالوهم (دفعوا زيادة)
public function creditors()
{
    $clients = Casnos::all()
        ->filter(fn ($client) => $client->getAdjustedBalance() < 0)
        ->values();

    foreach ($clients as $client) {
        $client->original_remaining = $client->getOriginalRemaining();
        $client->months_late = $client->getMonthsLate();
        $client->penalty_rate = $client->getPenaltyRate();
        $client->penalty_amount = $client->getPenaltyAmount();
        $client->adjusted_due = $client->getAdjustedDue();
        $client->adjusted_balance = $client->getAdjustedBalance();
        $client->adjusted_remaining = $client->getAdjustedRemaining();
    }

    return view('casnos.creditors', compact('clients'));
}

public function debtors()
{
    $clients = Casnos::all()
        ->filter(fn ($client) => $client->getAdjustedBalance() > 0)
        ->values();

    foreach ($clients as $client) {
        $client->original_remaining = $client->getOriginalRemaining();
        $client->months_late = $client->getMonthsLate();
        $client->penalty_amount = $client->getPenaltyAmount();
        $client->adjusted_due = $client->getAdjustedDue();
        $client->adjusted_balance = $client->getAdjustedBalance();
    }

    return view('casnos.debtors', compact('clients'));
}
   

public function print($id)
{
    $clients = Casnos::findOrFail($id);

    $html = view('casnos.pdf', compact('clients'))->render();

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'autoArabic' => true,      // تفعيل العربية تلقائياً
        'autoLangToFont' => true,  // اختيار الخط المناسب للعربية
        'autoScriptToLang' => true,
]);

    $mpdf->SetDirectionality('rtl');
    $mpdf->WriteHTML($html);

    return response($mpdf->Output('casnos.pdf', 'S'))
        ->header('Content-Type', 'application/pdf');
}
// فتح صفحة تذكير WhatsApp
public function whatsappReminder($id)
{
    $client = Casnos::findOrFail($id);

    $remaining = $client->getAdjustedRemaining();

    // إذا خلّص الدين، لا نسمح بإرسال تذكير
    if ($client->getOriginalRemaining() <= 0 || $remaining <= 0) {
        return redirect()->route('casnos.index')
            ->with('error', 'هذا العميل قام بتسديد كامل المبلغ.');
    }

    // يجب مرور 25 يوماً من تاريخ الدفع
    if (
        !$client->date_paiement ||
        \Carbon\Carbon::parse($client->date_paiement)->addDays(25)->gt(now())
    ) {
        return redirect()->route('casnos.index')
            ->with('error', 'لم يحن موعد إرسال التذكير بعد.');
    }

    // إذا سبق إرسال تذكير، يجب انتظار 3 أيام
    if (
        $client->last_whatsapp_reminder_at &&
        $client->last_whatsapp_reminder_at->copy()->addDays(3)->gt(now())
    ) {
        return redirect()->route('casnos.index');
    }

    $phone = $client->phone ?? '';

    return view('casnos.whatsapp', compact(
        'client',
        'remaining',
        'phone'
    ));
}


// تسجيل تاريخ التذكير
public function markWhatsappReminderSent($id)
{
    $client = Casnos::findOrFail($id);

    $remaining = $client->getAdjustedRemaining();

    if ($client->getOriginalRemaining() <= 0 || $remaining <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'الدين مسدد بالكامل.'
        ], 422);
    }

    if (
        !$client->date_paiement ||
        \Carbon\Carbon::parse($client->date_paiement)->addDays(25)->gt(now())
    ) {
        return response()->json([
            'success' => false,
            'message' => 'لم يحن موعد التذكير بعد.'
        ], 422);
    }

    if (
        $client->last_whatsapp_reminder_at &&
        $client->last_whatsapp_reminder_at->copy()->addDays(3)->gt(now())
    ) {
        return response()->json([
            'success' => false,
            'message' => 'يجب انتظار 3 أيام بين التذكيرات.'
        ], 422);
    }

    $client->last_whatsapp_reminder_at = now();
    $client->save();

    return response()->json([
        'success' => true
    ]);
}
}
