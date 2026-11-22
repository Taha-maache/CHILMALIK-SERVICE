<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Trader;
use App\Models\TraderTax;
use Illuminate\Http\Request;
use App\Http\Controllers\TraderTaxController;
use Mpdf\Mpdf;
use App\Models\Activity;
use App\Models\ActivityFr;
class TraderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index(Request $request)
{
    $search = $request->input('search');
    $sort = $request->input('sort', 'id');
    $direction = $request->input('direction', 'desc');

    $traders = Trader::with('traderTaxes') // نربطو الضرائب بالتاجر هنا
        ->when($search, function ($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                  ->orWhere('NIN', 'like', $search);
        })
        ->orderBy($sort, $direction)
        ->paginate(1000)
        ->appends(['search' => $search, 'sort' => $sort, 'direction' => $direction]);
$sidebarNotifications['trader_taxes'] = TraderTax::where('pay_type', 'credit')
    ->whereNotNull('credit_date')
    ->whereDate('credit_date', '<', now()->toDateString())
    ->count();
    // نحينا $trader_taxes = TraderTax::... لأننا جبناها داخل الـ traders ديجا
    return view('traders.index', compact('traders', 'search', 'sort', 'direction', 'sidebarNotifications'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('traders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
$validated = $request->validate([
    'first_name' => 'required|string|max:255',
    'last_name' => 'nullable|string|max:255',
    'date_of_birth' => 'nullable|date',
    'place_of_birth' => 'nullable|string|max:255',
    'NIN' => 'nullable|string|max:255',
'activities' => 'nullable|array',
'activities_fr' => 'nullable|array',
'register_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'nif_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'nis_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'g8_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'rent_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'birth_certificate_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'cart_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'residence_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
'main_activity_fr_id' => 'nullable|integer|exists:activities_fr,id',
    ]);

    $data = $request->all();

    $documents = [
        'register_pdf',
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'rent_pdf',
        'birth_certificate_pdf',
        'cart_pdf',
        'residence_pdf'
    ];

    foreach ($documents as $doc) {

        if ($request->hasFile($doc)) {

            $data[$doc] = $request
                ->file($doc)
                ->store('trader_documents', 'public');
        }
    }

if ($request->activity_address_g08 == 'other') {
    $data['activity_address_g08'] = $request->activity_address_other;
}
    
$trader = Trader::create($data);

// ربط activities
if ($request->activities) {
    $trader->activities()->attach($request->activities);
}
if ($request->activities_fr) {
    $trader->activitiesFr()->attach($request->activities_fr);
}
$selectedFrenchActivities = $request->input('activities_fr', []);
$mainActivityId = $request->input('main_activity_fr_id');

if (
    $mainActivityId &&
    in_array((string) $mainActivityId, array_map('strval', $selectedFrenchActivities), true)
) {
    $trader->main_activity_fr_id = $mainActivityId;
} else {
    $trader->main_activity_fr_id = $selectedFrenchActivities[0] ?? null;
}

$trader->save();

    return redirect()
        ->route('traders.index')
        ->with('success', 'Trader created successfully.');
}
    /**
     * Display the specified resource.
     */
public function show(Trader $trader)
{
    // نجبدو التاجر ونجيبو معاه قاع الضرائب تاعه مستفين من الأحدث للأقدم
    $trader->load(['traderTaxes' => function($query) {
        $query->orderBy('tax_year', 'desc');
    }]);

    return view('traders.show', compact('trader'));
}
    /**
     * Show the form for editing the specified resource.
     */
public function edit(Trader $trader)
{
    $trader->load('activities', 'activitiesFr');
    return view('traders.edit', compact('trader'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trader $trader)
{
    $validated = $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'date_of_birth' => 'nullable|date',
        'place_of_birth' => 'nullable|string|max:255',
        'NIN' => 'nullable|string|max:255',
        'activities' => 'nullable|array',
        'activities_fr' => 'nullable|array',
        'main_activity_fr_id' => 'nullable|integer|exists:activities_fr,id',
    ]);

    // update normal fields
    $trader->update($request->except([
        'register_pdf',
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'rent_pdf',
        'birth_certificate_pdf',
        'cart_pdf',
        'residence_pdf',
    ]));

    // documents list
    $documents = [
        'register_pdf',
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'rent_pdf',
        'birth_certificate_pdf',
        'cart_pdf',
        'residence_pdf'
    ];

    foreach ($documents as $doc) {
        if ($request->hasFile($doc)) {

            // (اختياري) نحيو القديم
            // if ($trader->$doc) {
            //     Storage::disk('public')->delete($trader->$doc);
            // }

            $path = $request->file($doc)->store('trader_documents', 'public');

            // غير هذا الملف فقط يتبدل
            $trader->$doc = $path;
        }
    }
if ($request->activity_address_g08 == 'other') {
    $trader->activity_address_g08 = $request->activity_address_other;
}
    $trader->save();

 if ($request->has('activities')) {
    $trader->activities()->sync($request->activities);
} else {
    $trader->activities()->detach();
}
if ($request->has('activities_fr')) {
    $trader->activitiesFr()->sync($request->activities_fr);
} else {
    $trader->activitiesFr()->detach();
}
$selectedFrenchActivities = $request->input('activities_fr', []);
$mainActivityId = $request->input('main_activity_fr_id');

if (
    $mainActivityId &&
    in_array((string) $mainActivityId, array_map('strval', $selectedFrenchActivities), true)
) {
    $trader->main_activity_fr_id = $mainActivityId;
} else {
    $trader->main_activity_fr_id = $selectedFrenchActivities[0] ?? null;
}

$trader->save();

    return redirect()->route('traders.index')
        ->with('success', 'Trader updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trader $trader)
    {
        $trader->delete();
        return redirect()->route('traders.index')->with('success', 'Trader deleted successfully.');
    }

public function pdfFull(Request $request, Trader $trader, $type = 'full')
{
    $color = $request->color ?? 'black';

    // نمرر الـ type للـ blade
    

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A3',
         'autoScriptToLang' => true,
        'autoLangToFont' => true,
        'margin_top' => 0,
        'margin_right' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'default_font' => 'amiri',
    ]);
  $total = $this->calculateTotal($trader);

    $html = view('pdf.trader_full', compact('trader', 'total', 'color'))->render();

   
$mpdf->WriteHTML($html);

return response(
    $mpdf->Output('', 'S'),
    200,
    ['Content-Type' => 'application/pdf']
);}

public function pdfG08(Trader $trader, $type = 'g08')
{
    // نمرر الـ type للـ blade
    

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
         'autoScriptToLang' => true,
        'autoLangToFont' => true,
        'margin_top' => 0,
        'margin_right' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'default_font' => 'amiri',
    ]);

   $html = view('pdf.G08_pdf', compact('trader'))->render();

$mpdf->WriteHTML($html);

return response(
    $mpdf->Output('', 'S'),
    200,
    ['Content-Type' => 'application/pdf']
);}




public function getNotifications()
{
    // نجيبو التجار اللي فات عليهم 7 أيام من تاريخ التسجيل ومازال ما ديكلاراوش
    $pending_casnos = \App\Models\Trader::where('is_casnos_declared', false)
        ->where('Date_of_this_register', '<=', now()->subDays(6))
        ->get();

    return $pending_casnos;
}

// دالة لتحديث الحالة عند الضغط على "نعم"
public function declareCasnos($id)
{
    $trader = \App\Models\Trader::findOrFail($id);
    $trader->update(['is_casnos_declared' => true]);

    return back()->with('success', 'تم تحديث حالة CASNOS بنجاح');
}

public function changeStatus(Trader $trader)
{
    switch ($trader->status) {

        case 'nouveau':
            $trader->status = 'transfere_cnrc';
            $trader->transfere_cnrc_at = now();
            break;

        case 'transfere_cnrc':
            $trader->status = 'recupere_cnrc';
            $trader->recupere_cnrc_at = now();
            break;

        case 'recupere_cnrc':
            $trader->status = 'livre_client';
            break;

        default:
            return back();
    }

    $trader->save();

    return back()->with('success', 'Statut modifié avec succès.');
}

public function getCnrcNotifications()
{
    return Trader::where('status', 'transfere_cnrc')
        ->whereNotNull('transfere_cnrc_at')
        ->where('transfere_cnrc_at', '<=', now()->subDays(4))
        ->get();
}
public function getDeliveryNotifications()
{
    return Trader::where('status', 'recupere_cnrc')
        ->whereNotNull('recupere_cnrc_at')
        ->where('recupere_cnrc_at', '<=', now()->subDays(2))
        ->get();
}
private function calculateTotal(Trader $trader)
{
    $prices = [
        'kadamat' => 2912,
        'ta3dil' => 2912,
        'tejir_moutana9il' => 1000,
        'tajziaa' => 3712,
        'sina3a' => 3712,
        'jemla' => 2472,
    ];

    $total = 0;

    foreach ($trader->operation_type ?? [] as $operation) {
        $total += $prices[$operation] ?? 0;
    }

    $total += ($trader->number_of_codes * 240);

    return $total;
}
public function whatsappRegisterReminder(Trader $trader)
{
    abort_unless($trader->status === 'recupere_cnrc', 403);

    abort_if(
        !is_null($trader->whatsapp_register_reminded_at),
        404
    );

    return view('traders.whatsapp-register-reminder', compact('trader'));
}

public function markWhatsappRegisterReminderSent(Trader $trader)
{
    if ($trader->status !== 'recupere_cnrc') {
        return response()->json([
            'success' => false,
            'message' => 'التاجر لم يسترجع ملفه من CNRC بعد.',
        ], 422);
    }

    if (!is_null($trader->whatsapp_register_reminded_at)) {
        return response()->json([
            'success' => false,
            'message' => 'تم تسجيل التذكير لهذا التاجر من قبل.',
        ], 409);
    }

    $trader->whatsapp_register_reminded_at = now();
    $trader->save();

    return response()->json([
        'success' => true,
        'message' => 'تم تسجيل التذكير بنجاح.',
    ]);
}
public function getSidebarNotificationCounts()
{
    return [
        'traders_casnos' => $this->getNotifications()->count(),
        'traders_cnrc' => $this->getCnrcNotifications()->count(),
        'traders_delivery' => $this->getDeliveryNotifications()->count(),
    ];
}  
} 