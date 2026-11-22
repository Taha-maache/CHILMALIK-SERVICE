<?php

namespace App\Http\Controllers;

use App\Models\Jibayatic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JibayaticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jibayatics = Jibayatic::latest()->get();

        return view('jibayatics.index', compact('jibayatics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jibayatics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'NIN' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'mot_de_passe' => 'nullable|string|max:255',
            'prove_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('prove_pdf')) {

            $file = $request->file('prove_pdf');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->storeAs('jibayatics', $filename, 'public');

            $data['prove_pdf'] = $filename;
        }

        Jibayatic::create($data);

        return redirect()->route('jibayatics.index')
                         ->with('success', 'Ajout effectué avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jibayatic $jibayatic)
    {
        return view('jibayatics.edit', compact('jibayatic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jibayatic $jibayatic)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'NIN' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'mot_de_passe' => 'nullable|string|max:255',
            'prove_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('prove_pdf')) {

            if (
                $jibayatic->prove_pdf &&
                Storage::disk('public')->exists('jibayatics/'.$jibayatic->prove_pdf)
            ) {
                Storage::disk('public')->delete('jibayatics/'.$jibayatic->prove_pdf);
            }

            $file = $request->file('prove_pdf');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->storeAs('jibayatics', $filename, 'public');

            $data['prove_pdf'] = $filename;
        }

        $jibayatic->update($data);

        return redirect()->route('jibayatics.index')
                         ->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jibayatic $jibayatic)
    {
        if (
            $jibayatic->prove_pdf &&
            Storage::disk('public')->exists('jibayatics/'.$jibayatic->prove_pdf)
        ) {
            Storage::disk('public')->delete('jibayatics/'.$jibayatic->prove_pdf);
        }

        $jibayatic->delete();

        return redirect()->route('jibayatics.index')
                         ->with('success', 'Suppression effectuée avec succès');
    }

    /**
     * Delete only the PDF.
     */
    public function deletePdf(Jibayatic $jibayatic)
    {
        if (
            $jibayatic->prove_pdf &&
            Storage::disk('public')->exists('jibayatics/'.$jibayatic->prove_pdf)
        ) {
            Storage::disk('public')->delete('jibayatics/'.$jibayatic->prove_pdf);
        }

        $jibayatic->update([
            'prove_pdf' => null
        ]);

        return back()->with('success', 'PDF supprimé avec succès.');
    }
}