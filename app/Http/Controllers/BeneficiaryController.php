<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beneficiaries = Beneficiary::latest()->get();

        return view('beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beneficiaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $data = $request->all();

    if ($request->hasFile('cart_pdf')) {

        $file = $request->file('cart_pdf');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('beneficiaries', $filename, 'public');

        $data['cart_pdf'] = $filename;
    }

    Beneficiary::create($data);

    return redirect()->route('beneficiaries.index')
                     ->with('success', 'Ajout effectué avec succès');
}
    /**
     * Display the specified resource.
     */
    public function show(Beneficiary $beneficiary)
    {
        return view('beneficiaries.show', compact('beneficiary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficiary $beneficiary)
    {
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, Beneficiary $beneficiary)
{
    $data = $request->all();

    if ($request->hasFile('cart_pdf')) {

        if ($beneficiary->cart_pdf &&
            Storage::disk('public')->exists('beneficiaries/' . $beneficiary->cart_pdf)) {

            Storage::disk('public')->delete('beneficiaries/' . $beneficiary->cart_pdf);
        }

        $file = $request->file('cart_pdf');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('beneficiaries', $filename, 'public');

        $data['cart_pdf'] = $filename;
    }

    $beneficiary->update($data);

    return redirect()->route('beneficiaries.index')
                     ->with('success', 'Modification effectuée avec succès');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        return redirect()->route('beneficiaries.index')
                         ->with('success', 'Suppression effectuée avec succès');
    }
public function pdfAR($id)
{
    $beneficiary = Beneficiary::findOrFail($id);

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'default_font' => 'amiri',
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 0,
    ]);

    $html = view('beneficiaries.pdf_ar', compact('beneficiary'))->render();

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('beneficiary_'.$beneficiary->id.'.pdf', 'S'),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="beneficiary_'.$beneficiary->id.'.pdf"'
        ]
    );
}
public function pdfFR($id)
{
    $beneficiary = Beneficiary::findOrFail($id);

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'default_font' => 'arabictypesetting',
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 0,
    ]);

    $html = view('beneficiaries.pdf_fr', compact('beneficiary'))->render();

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('beneficiary_'.$beneficiary->id.'.pdf', 'S'),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="beneficiary_'.$beneficiary->id.'.pdf"'
        ]
    );
}
    }