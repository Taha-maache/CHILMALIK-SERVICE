<?php

namespace App\Http\Controllers;
use App\Models\Damancom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DamancomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $damancoms = Damancom::latest()->get();

    return view('damancoms.index', compact('damancoms'));
}

    /**
     * Show the form for creating a new resource.
     */
 public function create()
{
    return view('damancoms.create');
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

        $file->storeAs('damancoms', $filename, 'public');

        $data['prove_pdf'] = $filename;
    }

    Damancom::create($data);

    return redirect()->route('damancoms.index')
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
 public function edit(Damancom $damancom)
{
    return view('damancoms.edit', compact('damancom'));
}
    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, Damancom $damancom)
{
    $data = $request->validate([
        'full_name' => 'required|string|max:255',
        'NIN' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'code' => 'nullable|string|max:255',
        'mot_de_passe' => 'nullable|string|max:255',
        'prove_pdf' => 'nullable|mimes:pdf|max:10240',
    ]);

    if ($request->hasFile('prove_pdf')) {

        if (
            $damancom->prove_pdf &&
            Storage::disk('public')->exists('damancoms/'.$damancom->prove_pdf)
        ) {
            Storage::disk('public')->delete('damancoms/'.$damancom->prove_pdf);
        }

        $file = $request->file('prove_pdf');

        $filename = time().'_'.$file->getClientOriginalName();

        $file->storeAs('damancoms', $filename, 'public');

        $data['prove_pdf'] = $filename;
    }

    $damancom->update($data);

    return redirect()->route('damancoms.index')
                     ->with('success', 'Modification effectuée avec succès');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(Damancom $damancom)
{
    if ($damancom->prove_pdf &&
        Storage::disk('public')->exists('damancoms/'.$damancom->prove_pdf)) {

        Storage::disk('public')->delete('damancoms/'.$damancom->prove_pdf);
    }

    $damancom->delete();

    return redirect()->route('damancoms.index')
                     ->with('success','Suppression effectuée avec succès');
}

public function deletePdf(Damancom $damancom)
{
    if (
        $damancom->prove_pdf &&
        Storage::disk('public')->exists('damancoms/'.$damancom->prove_pdf)
    ) {

        Storage::disk('public')->delete('damancoms/'.$damancom->prove_pdf);
    }

    $damancom->update([
        'prove_pdf' => null
    ]);

    return back()->with('success','PDF supprimé avec succès.');
}

}
