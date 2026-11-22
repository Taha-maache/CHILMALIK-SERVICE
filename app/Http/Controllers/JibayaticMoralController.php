<?php

namespace App\Http\Controllers;

use App\Models\JibayaticMoral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JibayaticMoralController extends Controller
{
    public function index()
    {
        $jibayatics = JibayaticMoral::latest()->get();

        return view('jibayatic_moral.index', compact('jibayatics'));
    }

    public function create()
    {
        return view('jibayatic_moral.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label_name'   => 'required|string|max:255',
            'NIN'          => 'required|string|max:255',
            'phone'        => 'required|string|max:255',
            'code'         => 'required|string|max:255',
            'mot_de_passe' => 'required|string|max:255',
            'prove_pdf'    => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
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
                ->store('jibayatic_moral', 'public');
        }

        JibayaticMoral::create($data);

        return redirect()
            ->route('jibayatic-moral.index')
            ->with('success', 'Compte créé avec succès.');
    }

    public function edit(JibayaticMoral $jibayatic_moral)
    {
        return view('jibayatic_moral.edit', [
            'jibayatic' => $jibayatic_moral
        ]);
    }

    public function update(Request $request, JibayaticMoral $jibayatic_moral)
    {
        $request->validate([
            'label_name'   => 'required|string|max:255',
            'NIN'          => 'required|string|max:255',
            'phone'        => 'required|string|max:255',
            'code'         => 'required|string|max:255',
            'mot_de_passe' => 'required|string|max:255',
            'prove_pdf'    => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
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
                $jibayatic_moral->prove_pdf &&
                Storage::disk('public')->exists($jibayatic_moral->prove_pdf)
            ) {
                Storage::disk('public')->delete($jibayatic_moral->prove_pdf);
            }

            $data['prove_pdf'] = $request->file('prove_pdf')
                ->store('jibayatic_moral', 'public');
        }

        $jibayatic_moral->update($data);

        return redirect()
            ->route('jibayatic-moral.index')
            ->with('success', 'Compte modifié avec succès.');
    }

    public function destroy(JibayaticMoral $jibayatic_moral)
    {
        if (
            $jibayatic_moral->prove_pdf &&
            Storage::disk('public')->exists($jibayatic_moral->prove_pdf)
        ) {
            Storage::disk('public')->delete($jibayatic_moral->prove_pdf);
        }

        $jibayatic_moral->delete();

        return redirect()
            ->route('jibayatic-moral.index')
            ->with('success', 'Compte supprimé.');
    }

    public function deleteFile(JibayaticMoral $jibayatic_moral, $field)
    {
        $allowed = ['prove_pdf'];

        if (!in_array($field, $allowed)) {
            abort(404);
        }

        if (
            $jibayatic_moral->$field &&
            Storage::disk('public')->exists($jibayatic_moral->$field)
        ) {
            Storage::disk('public')->delete($jibayatic_moral->$field);
        }

        $jibayatic_moral->update([
            $field => null,
        ]);

        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}