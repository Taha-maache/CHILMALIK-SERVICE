<?php

namespace App\Http\Controllers;

use App\Models\DamancomMoral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DamancomMoralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $damancoms = DamancomMoral::latest()->get();

        return view('damancom_moral.index', compact('damancoms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('damancom_moral.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label_name'   => 'required|string|max:255',
            'NIN'          => 'required|string|max:255',
            'phone'        => 'required|string|max:255',
            'code'         => 'required|string|max:255',
            'mot_de_passe' => 'required|string|max:255',
            'prove_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only([
            'label_name',
            'NIN',
            'phone',
            'code',
            'mot_de_passe',
        ]);

        if ($request->hasFile('prove_pdf')) {
            $data['prove_pdf'] = $request->file('prove_pdf')
                ->store('damancom_moral', 'public');
        }

        DamancomMoral::create($data);

        return redirect()
            ->route('damancom-moral.index')
            ->with('success', 'Damancom créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DamancomMoral $damancom_moral)
    {
        return view('damancom_moral.edit', [
            'damancom' => $damancom_moral
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DamancomMoral $damancom_moral)
    {
        $request->validate([
            'label_name'   => 'required|string|max:255',
            'NIN'          => 'required|string|max:255',
            'phone'        => 'required|string|max:255',
            'code'         => 'required|string|max:255',
            'mot_de_passe' => 'required|string|max:255',
            'prove_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only([
            'label_name',
            'NIN',
            'phone',
            'code',
            'mot_de_passe',
        ]);

        if ($request->hasFile('prove_pdf')) {

            if (
                $damancom_moral->prove_pdf &&
                Storage::disk('public')->exists($damancom_moral->prove_pdf)
            ) {
                Storage::disk('public')->delete($damancom_moral->prove_pdf);
            }

            $data['prove_pdf'] = $request->file('prove_pdf')
                ->store('damancom_moral', 'public');
        }

        $damancom_moral->update($data);

        return redirect()
            ->route('damancom-moral.index')
            ->with('success', 'Damancom modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DamancomMoral $damancom_moral)
    {
        if (
            $damancom_moral->prove_pdf &&
            Storage::disk('public')->exists($damancom_moral->prove_pdf)
        ) {
            Storage::disk('public')->delete($damancom_moral->prove_pdf);
        }

        $damancom_moral->delete();

        return redirect()
            ->route('damancom-moral.index')
            ->with('success', 'Damancom supprimé avec succès.');

            }

public function deleteFile(DamancomMoral $damancom_moral, $field)
{
    $allowed = [
        'prove_pdf',
    ];

    if (! in_array($field, $allowed)) {
        abort(404);
    }

    if (
        $damancom_moral->$field &&
        Storage::disk('public')->exists($damancom_moral->$field)
    ) {
        Storage::disk('public')->delete($damancom_moral->$field);
    }

    $damancom_moral->update([
        $field => null,
    ]);

    return back()->with('success', 'Fichier supprimé avec succès.');
}
            }