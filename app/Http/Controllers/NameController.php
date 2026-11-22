<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Name;


class NameController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $names = Name::when($search, function ($query) use ($search) {

            $query->where('full_name', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
                 
        })->latest()->paginate(150);

        return view('names.index', compact('names'));
    }


    public function create()
    {
        return view('names.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'address' => 'required',
            'type' => 'required',
        ]);

        Name::create($request->all());

        return redirect()
            ->route('names.index')
            ->with('success', 'تمت الإضافة بنجاح');
    }


    public function edit(string $id)
    {
        $name = Name::findOrFail($id);

        return view('names.edit', compact('name'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'full_name' => 'required',
            'address' => 'required',
            'type' => 'required',
        ]);

        $name = Name::findOrFail($id);

        $name->update($request->all());

        return redirect()
            ->route('names.index')
            ->with('success', 'تم التعديل بنجاح');
    }


    public function destroy(string $id)
    {
        $name = Name::findOrFail($id);

        $name->delete();

        return redirect()
            ->route('names.index')
            ->with('success', 'تم الحذف بنجاح');
    }
    public function pdfNaming(Name $name, $type = 'naming')
{
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

    $html = view('pdf.name_naming', compact('name', 'type'))->render();

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('', 'S'),
        200,
        ['Content-Type' => 'application/pdf']
    );
}
}