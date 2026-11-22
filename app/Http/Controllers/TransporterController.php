<?php

namespace App\Http\Controllers;
use Mpdf\Mpdf;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TransporterController extends Controller
{
    // 📌 LIST
public function index(Request $request)
{
    $search = $request->input('search');

    $transporters = Transporter::when($search, function ($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('number_of_identity_card', 'like', "%{$search}%");
        })
        ->paginate(150); // هنا حددنا 10 برك في الصفحة

    return view('transporters.index', compact('transporters'));
}
    // 📌 SHOW CREATE PAGE
    public function create()
    {
        return view('transporters.create');
    }

    // 📌 STORE (SAVE NEW)
public function store(Request $request)
{
    $validated = $request->validate([

        'register_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'scanner_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'carte_grise_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'mou9arar_na9l_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'kafaa_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'permit_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'permit_cerculer_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'casnos_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'nif_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

    ]);

    $data = $request->all();

    $documents = [
        'register_pdf',
        'scanner_pdf',
        'carte_grise_pdf',
        'mou9arar_na9l_pdf',
        'kafaa_pdf',
        'permit_pdf',
        'permit_cerculer_pdf',
        'casnos_pdf',
        'nif_pdf',
    ];

    foreach ($documents as $doc) {

        if ($request->hasFile($doc)) {

            $data[$doc] = $request
                ->file($doc)
                ->store('transporter_documents', 'public');

        }

    }

    Transporter::create($data);

    return redirect()
        ->route('transporters.index')
        ->with('success', 'Created successfully');
}

    // 📌 SHOW EDIT PAGE
    public function edit($id)
    {
        $transporter = Transporter::findOrFail($id);

        return view('transporters.edit', compact('transporter'));
    }

    // 📌 UPDATE
public function update(Request $request, Transporter $transporter)
{
    $validated = $request->validate([

        'register_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'scanner_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'carte_grise_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'mou9arar_na9l_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'kafaa_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'permit_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'permit_cerculer_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'casnos_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'nif_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

    ]);

    $transporter->update($request->except([

        'register_pdf',
        'scanner_pdf',
        'carte_grise_pdf',
        'mou9arar_na9l_pdf',
        'kafaa_pdf',
        'permit_pdf',
        'permit_cerculer_pdf',
        'casnos_pdf',
        'nif_pdf',

    ]));

    $documents = [
        'register_pdf',
        'scanner_pdf',
        'carte_grise_pdf',
        'mou9arar_na9l_pdf',
        'kafaa_pdf',
        'permit_pdf',
        'permit_cerculer_pdf',
        'casnos_pdf',
        'nif_pdf',
    ];

    foreach ($documents as $doc) {

        if ($request->hasFile($doc)) {

            $path = $request->file($doc)
                ->store('transporter_documents', 'public');

            $transporter->$doc = $path;

        }

    }

    $transporter->save();

    return redirect()
        ->route('transporters.index')
        ->with('success', 'Updated successfully');
}

public function Pdf($id)
{
    $transporter = Transporter::findOrFail($id);

    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'mode' => 'utf-8',
        'autoArabic' => true,      // تفعيل العربية تلقائياً
        'autoLangToFont' => true,  // اختيار الخط المناسب للعربية
        'autoScriptToLang' => true,
    ]);

    $html = view('transporters.pdf', compact('transporter'))->render();

    $mpdf->WriteHTML($html);
    $mpdf->Output('transporter_'.$id.'.pdf', 'I');
}
public function destroy($id)
{
    $transporter = Transporter::findOrFail($id);
    $transporter->delete();

    return redirect()->route('transporters.index')
        ->with('success', 'Deleted successfully');
}
public function deleteFile(Transporter $transporter, $field)
{
    $allowed = [
        'register_pdf',
        'scanner_pdf',
        'carte_grise_pdf',
        'mou9arar_na9l_pdf',
        'kafaa_pdf',
        'permit_pdf',
        'permit_cerculer_pdf',
        'casnos_pdf',
        'nif_pdf',
    ];

    if (!in_array($field, $allowed)) {
        abort(404);
    }

    if ($transporter->$field) {

        Storage::disk('public')->delete($transporter->$field);

        $transporter->$field = null;

        $transporter->save();
    }

    return back()->with('success', 'Le fichier a été supprimé.');
}
    }