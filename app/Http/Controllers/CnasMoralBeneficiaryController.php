<?php

namespace App\Http\Controllers;

use App\Models\CnasMoralBeneficiary;
use Illuminate\Support\Facades\Storage;

class CnasMoralBeneficiaryController extends Controller
{
    public function destroy(CnasMoralBeneficiary $beneficiary)
    {
        $files = [

            'cart_pdf',
            'photo_pdf',
            'residence_pdf',

        ];

        foreach ($files as $file) {

            if (
                $beneficiary->$file &&
                Storage::disk('public')->exists($beneficiary->$file)
            ) {

                Storage::disk('public')->delete($beneficiary->$file);

            }

        }

        $beneficiary->delete();

        return back()->with('success', 'Bénéficiaire supprimé avec succès.');

    }

    public function deleteFile(CnasMoralBeneficiary $beneficiary, $field)
    {
        $allowed = [

            'cart_pdf',
            'photo_pdf',
            'residence_pdf',

        ];

        if (! in_array($field, $allowed)) {

            abort(404);

        }

        if (
            $beneficiary->$field &&
            Storage::disk('public')->exists($beneficiary->$field)
        ) {

            Storage::disk('public')->delete($beneficiary->$field);

        }

        $beneficiary->update([

            $field => null,

        ]);

        return back()->with('success', 'Fichier supprimé avec succès.');

    }
}