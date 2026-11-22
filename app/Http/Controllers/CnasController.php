<?php

namespace App\Http\Controllers;

use App\Models\Cnas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CnasBeneficiary;
class CnasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $cnases = Cnas::latest()->get();

    return view('cnases.index', compact('cnases'));
}

    /**
     * Show the form for creating a new resource.
     */
 public function create()
{
    return view('cnases.create');
}

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    $data = $request->validate([

        'full_name'=>'required|string|max:255',
        'NIN'=>'nullable|string|max:255',
        'phone'=>'nullable|string|max:255',
        'code'=>'nullable|string|max:255',
        'mot_de_passe'=>'nullable|string|max:255',

        'prove_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'rent_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'register_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'craft_cart_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'cart_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'birth_certificate_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'nif_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'chek_barre_pdf'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'beneficiaries.*.full_name' => 'required|string|max:255',
    'beneficiaries.*.cart_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
    'beneficiaries.*.birth_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
    'beneficiaries.*.photo_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

    ]);

    $files = [

        'prove_pdf',
        'rent_pdf',
        'register_pdf',
        'craft_cart_pdf',
        'cart_pdf',
        'birth_certificate_pdf',
        'nif_pdf',
        'chek_barre_pdf',

    ];

    foreach($files as $file){

        if($request->hasFile($file)){

            $name=time().'_'.$request->$file->getClientOriginalName();

            $request->$file->storeAs('cnases',$name,'public');

            $data[$file]=$name;

        }

    }

    $cnas = Cnas::create($data);
if ($request->has('beneficiaries')) {

    foreach ($request->beneficiaries as $index => $beneficiary) {

        $cart = null;
        $birth = null;
        $photo = null;

        if ($request->hasFile("beneficiaries.$index.cart_pdf")) {

            $file = $request->file("beneficiaries.$index.cart_pdf");

            $cart = time().'_cart_'.$index.'.'.$file->getClientOriginalExtension();

            $file->storeAs('cnas_beneficiaries', $cart, 'public');

        }

        if ($request->hasFile("beneficiaries.$index.birth_pdf")) {

            $file = $request->file("beneficiaries.$index.birth_pdf");

            $birth = time().'_birth_'.$index.'.'.$file->getClientOriginalExtension();

            $file->storeAs('cnas_beneficiaries', $birth, 'public');

        }

        if ($request->hasFile("beneficiaries.$index.photo_pdf")) {

            $file = $request->file("beneficiaries.$index.photo_pdf");

            $photo = time().'_photo_'.$index.'.'.$file->getClientOriginalExtension();

            $file->storeAs('cnas_beneficiaries', $photo, 'public');

        }

        CnasBeneficiary::create([

            'cnas_id'   => $cnas->id,

            'full_name' => $beneficiary['full_name'],

            'cart_pdf'  => $cart,

            'birth_pdf' => $birth,

            'photo_pdf' => $photo,

        ]);

    }

}

    return redirect()->route('cnases.index')
        ->with('success','Ajout effectué avec succès');
}

    /**
     * Display the specified resource.
     */
    public function show(Cnas $cnas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit($id)
{
    $cnas = Cnas::findOrFail($id);

    return view('cnases.edit', [
        'cnas' => $cnas
    ]);
}
    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $cnase)
{
    $cnas = Cnas::findOrFail($cnase);    
    $data = $request->validate([

        'full_name' => 'required|string|max:255',
        'NIN' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'code' => 'nullable|string|max:255',
        'mot_de_passe' => 'nullable|string|max:255',

        'prove_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'rent_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'register_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'craft_cart_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'cart_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'birth_certificate_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'nif_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'chek_barre_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

        'beneficiaries.*.full_name' => 'required|string|max:255',
        'beneficiaries.*.cart_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'beneficiaries.*.birth_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'beneficiaries.*.photo_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    $files = [

        'prove_pdf',
        'rent_pdf',
        'register_pdf',
        'craft_cart_pdf',
        'cart_pdf',
        'birth_certificate_pdf',
        'nif_pdf',
        'chek_barre_pdf',

    ];

    foreach ($files as $file) {

        if ($request->hasFile($file)) {

            if (
                $cnas->$file &&
                Storage::disk('public')->exists('cnases/' . $cnas->$file)
            ) {

                Storage::disk('public')->delete('cnases/' . $cnas->$file);

            }

            $name = time() . '_' . $request->file($file)->getClientOriginalName();

            $request->file($file)->storeAs('cnases', $name, 'public');

            $data[$file] = $name;
        }
    }

    $cnas->update($data);
if ($request->has('beneficiaries')) {

    foreach ($request->beneficiaries as $beneficiary) {

        if (!empty($beneficiary['id'])) {

            $row = CnasBeneficiary::find($beneficiary['id']);

        } else {

            $row = new CnasBeneficiary();
            $row->cnas_id = $cnas->id;
        }

        $row->full_name = $beneficiary['full_name'];

        // Carte
        if (isset($beneficiary['cart_pdf']) && $beneficiary['cart_pdf']) {

            if ($row->cart_pdf) {
                Storage::disk('public')->delete('cnas_beneficiaries/'.$row->cart_pdf);
            }

            $file = $beneficiary['cart_pdf'];

            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();

            $file->storeAs('cnas_beneficiaries', $name, 'public');

            $row->cart_pdf = $name;
        }

        // Birth
        if (isset($beneficiary['birth_pdf']) && $beneficiary['birth_pdf']) {

            if ($row->birth_pdf) {
                Storage::disk('public')->delete('cnas_beneficiaries/'.$row->birth_pdf);
            }

            $file = $beneficiary['birth_pdf'];

            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();

            $file->storeAs('cnas_beneficiaries', $name, 'public');

            $row->birth_pdf = $name;

        }
        if (isset($beneficiary['photo_pdf']) && $beneficiary['photo_pdf']) {

            if ($row->photo_pdf) {
                Storage::disk('public')->delete('cnas_beneficiaries/'.$row->photo_pdf);
            }

            $file = $beneficiary['photo_pdf'];

            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();

            $file->storeAs('cnas_beneficiaries', $name, 'public');

            $row->photo_pdf = $name;
        }


        $row->save();
    }
}
    

    return redirect()
        ->route('cnases.index')
        ->with('success', 'Modification effectuée avec succès');
}


    /**
     * Remove the specified resource from storage.
     */
 public function destroy(Cnas $cnas)
{
    $files=[

        'prove_pdf',
        'rent_pdf',
        'register_pdf',
        'craft_cart_pdf',
        'cart_pdf',
        'birth_certificate_pdf',
        'nif_pdf',
        'chek_barre_pdf',

    ];

    foreach($files as $file){

        if(
            $cnas->$file &&
            Storage::disk('public')->exists('cnases/'.$cnas->$file)
        ){

            Storage::disk('public')->delete('cnases/'.$cnas->$file);

        }

    }

    $cnas->delete();

    return redirect()->route('cnases.index')
        ->with('success','Suppression effectuée avec succès');
}
public function deleteFile(Cnas $cnas, $file)
{
    $allowed = [

        'prove_pdf',
        'rent_pdf',
        'register_pdf',
        'craft_cart_pdf',
        'cart_pdf',
        'birth_certificate_pdf',
        'nif_pdf',
        'chek_barre_pdf',

    ];

    if (!in_array($file, $allowed)) {
        abort(404);
    }

    if (
        $cnas->$file &&
        Storage::disk('public')->exists('cnases/' . $cnas->$file)
    ) {

        Storage::disk('public')->delete('cnases/' . $cnas->$file);

    }

    $cnas->update([
        $file => null
    ]);

    return back()->with('success', 'Fichier supprimé avec succès.');
}

}
