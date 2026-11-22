<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Tmoral;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Models\Representative;
class TmoralController extends Controller
{
    public function index()
    {
        $tmorals = Tmoral::latest()->paginate(150);
        return view('tmorals.index', compact('tmorals'));
    }

    public function create()
    {
        return view('tmorals.create');
    }

public function store(Request $request)
{
    $data = $request->except([
    'full_name',
    'representative_NIN',
    'representative_adjectif',
    'representative_address',
    'representative_nationality',
    'representative_date_of_birth',
    'representative_place_of_birth',
    'representative_father_name',
    'representative_mother_name'

]);
$files = [
    'register_pdf',
    'nif_pdf',
    'nis_pdf',
    'g8_pdf',
    'naming_pdf',
    'rent_pdf',
    'essential_law_pdf',
    'Boal_pdf',
    'fiche_navet_pdf'
];

foreach ($files as $field) {
    if ($request->hasFile($field)) {
        $data[$field] = $request->file($field)->store('documents', 'public');
    }
}

$tmoral = Tmoral::create($data);
if ($request->activities) {
    $tmoral->activities()->attach($request->activities);
}
if ($request->activities_fr) {
    $tmoral->activitiesFr()->attach($request->activities_fr);
}

for ($i = 0; $i < 7; $i++)
    {
        if (!empty($request->full_name[$i]))
        {
            $tmoral->representatives()->create([
                'full_name' => $request->full_name[$i],
                'NIN' => $request->representative_NIN[$i],
                'adjectif' => $request->representative_adjectif[$i],
                'address' => $request->representative_address[$i],
                'nationality' => $request->representative_nationality[$i],
                'date_of_birth' => $request->representative_date_of_birth[$i],
                'place_of_birth' => $request->representative_place_of_birth[$i],
                'father_name' => $request->representative_father_name[$i],
                'mother_name' => $request->representative_mother_name[$i],

                
            ]);
        }
    }

    return redirect()
        ->route('tmorals.index')
        ->with('success', 'تمت الإضافة بنجاح');
}

    public function show(Tmoral $tmoral)
    {
        //
    }

    public function edit(Tmoral $tmoral)
    {
        return view('tmorals.edit', compact('tmoral'));
    }

public function update(Request $request, Tmoral $tmoral)
{
    // 1. نحيّو arrays (representatives)
    $data = $request->except([
        'full_name',
        'representative_NIN',
        'representative_adjectif',
        'representative_address',
        'representative_nationality',
        'representative_date_of_birth',
        'representative_place_of_birth',
        'representative_father_name',
        'representative_mother_name',
        'register_pdf'
    ]);

    // 2. إصلاح Social_capital (إذا فيه comma)
    if (isset($data['Social_capital'])) {
        $data['Social_capital'] = str_replace(',', '', $data['Social_capital']);
        $data['Social_capital'] = (float) $data['Social_capital'];
    }

    // 3. معالجة الملف (PDF + JPG)
 $files = [
    'register_pdf',
    'nif_pdf',
    'nis_pdf',
    'g8_pdf',
    'naming_pdf',
    'rent_pdf',
    'essential_law_pdf',
    'Boal_pdf',
    'fiche_navet_pdf'
];

foreach ($files as $field) {
    if ($request->hasFile($field)) {
        $data[$field] = $request->file($field)->store('documents', 'public');
    }
}
    // 4. تحديث الشركة
    $tmoral->update($data);
$tmoral->activities()->sync($request->activities ?? []);
$tmoral->activitiesFr()->sync($request->activities_fr ?? []);
    // 5. حذف الممثلين القدامى
    $tmoral->representatives()->delete();

    // 6. إعادة الإضافة
    foreach ($request->full_name ?? [] as $i => $name) {
        if (!empty($name)) {
            $tmoral->representatives()->create([
                'full_name' => $name,
                'NIN' => $request->representative_NIN[$i] ?? null,
                'adjectif' => $request->representative_adjectif[$i] ?? null,
                'address' => $request->representative_address[$i] ?? null,
                'nationality' => $request->representative_nationality[$i] ?? null,
                'date_of_birth' => $request->representative_date_of_birth[$i] ?? null,
                'place_of_birth' => $request->representative_place_of_birth[$i] ?? null,
                'father_name' => $request->representative_father_name[$i] ?? null,
                'mother_name' => $request->representative_mother_name[$i] ?? null,
            ]);
        }
    }

    return redirect()
        ->route('tmorals.index')
        ->with('success', 'تم التعديل بنجاح');
}

    public function destroy(Tmoral $tmoral)
    {
        $tmoral->delete();

        return back()->with('success', 'تم الحذف بنجاح');
    }

public function pdf(Request $request,Tmoral $tmoral)
{
      $color = $request->query('color', 'black');

    // نسمحو فقط بـ black و blue
    if (!in_array($color, ['black', 'blue'])) {
        $color = 'black';
    }

    $mpdf = new Mpdf([
        'format' => 'A3',
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 00,
         'default_font' => 'arabictypesetting',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
    ]);

    $html = view('tmorals.pdf', compact('tmoral', 'color'))->render();

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('', 'S'),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="tmoral_'.$tmoral->id.'_'.$color.'.pdf"',
        ]
    );
}

public function pdfG08(Tmoral $tmoral)
{
    $mpdf = new Mpdf([
        'format' => 'A4',
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 00,
         'default_font' => 'arabictypesetting',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
    ]);

    $html = view('tmorals.pdfg08', compact('tmoral'))->render();

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('', 'S'),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="tmoral_'.$tmoral->id.'.pdf"',
        ]
    );
}

public function changeStatus(Tmoral $tmoral)
{
    switch ($tmoral->status) {

        case 'nouveau':
            $tmoral->status = 'transfere_cnrc';
            $tmoral->transfere_cnrc_at = now();
            break;

        case 'transfere_cnrc':
            $tmoral->status = 'recupere_cnrc';
            $tmoral->recupere_cnrc_at = now();
            break;

        case 'recupere_cnrc':
            $tmoral->status = 'livre_client';
            break;

        default:
            return back();
    }

    $tmoral->save();

    return back()->with('success', 'Statut modifié avec succès.');
}
public function getCnrcNotifications()
{
    return Tmoral::where('status', 'transfere_cnrc')
        ->whereNotNull('transfere_cnrc_at')
        ->where('transfere_cnrc_at', '<=', now()->subDays(4))
        ->get();
}
public function getDeliveryNotifications()
{
    return Tmoral::where('status', 'recupere_cnrc')
        ->whereNotNull('recupere_cnrc_at')
        ->where('recupere_cnrc_at', '<=', now()->subDays(2))
        ->get();
}
public function getImportResaleNotifications()
{
    return Tmoral::where('Import_for_resale_asis', 1)
        ->whereNotNull('Date_of_this_register')
        ->whereDate(
            'Date_of_this_register',
            '<=',
            Carbon::now()->subMonths(23)
        )
        ->get();
}
    }