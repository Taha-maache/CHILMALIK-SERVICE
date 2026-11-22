<?php

namespace App\Http\Controllers;

use App\Models\CnasBeneficiary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CnasBeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CnasBeneficiary $cnasBeneficiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CnasBeneficiary $cnasBeneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CnasBeneficiary $cnasBeneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CnasBeneficiary $cnasBeneficiary)
    {
        //
    }
    public function deleteFile(CnasBeneficiary $beneficiary, $file)
{
    $allowed = [

        'cart_pdf',
        'birth_pdf',
        'photo_pdf',

    ];

    if (!in_array($file, $allowed)) {
        abort(404);
    }

    if (
        $beneficiary->$file &&
        Storage::disk('public')->exists('beneficiaries/'.$beneficiary->$file)
    ) {

        Storage::disk('public')->delete('beneficiaries/'.$beneficiary->$file);

    }

    $beneficiary->update([
        $file => null
    ]);

    return back()->with('success','Fichier supprimé.');
}
}
