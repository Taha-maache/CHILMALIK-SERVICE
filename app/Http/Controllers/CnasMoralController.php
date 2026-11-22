<?php

namespace App\Http\Controllers;

use App\Models\CnasMoral;
use App\Models\CnasMoralBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CnasMoralController extends Controller
{
    public function index()
    {
        $cnasMorals = CnasMoral::latest()->get();

        return view('cnas_morals.index', compact('cnasMorals'));
    }

    public function create()
    {
        return view('cnas_morals.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'label_name' => 'required',
            'NIN' => 'required',
            'phone' => 'required',
            'code' => 'required',
            'mot_de_passe' => 'required',

            'prove_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'rent_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'G08_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'register_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cart_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'residence_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'Boal_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'rential_law_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'Nif_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'chek_baree_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',

        ]);

        $data = $request->only([

            'label_name',
            'NIN',
            'phone',
            'code',
            'mot_de_passe',

        ]);
                $files = [

            'prove_pdf',
            'rent_pdf',
            'G08_pdf',
            'register_pdf',
            'cart_pdf',
            'residence_pdf',
            'Boal_pdf',
            'rential_law_pdf',
            'Nif_pdf',
            'chek_baree_pdf',

        ];

        foreach ($files as $file) {

            if ($request->hasFile($file)) {

                $data[$file] = $request
                    ->file($file)
                    ->store('cnas_morals', 'public');

            }

        }

        $cnasMoral = CnasMoral::create($data);
                if ($request->has('beneficiaries')) {

            foreach ($request->beneficiaries as $beneficiary) {

                $beneficiaryData = [

                    'cnas_moral_id' => $cnasMoral->id,

                    'full_name' => $beneficiary['full_name'] ?? null,

                ];

                foreach ([
                    'cart_pdf',
                    'photo_pdf',
                    'residence_pdf'
                ] as $file) {

                    if (
                        isset($beneficiary[$file]) &&
                        $beneficiary[$file] instanceof \Illuminate\Http\UploadedFile
                    ) {

                        $beneficiaryData[$file] = $beneficiary[$file]
                            ->store('cnas_moral_beneficiaries', 'public');

                    }

                }

                CnasMoralBeneficiary::create($beneficiaryData);

            }

        }

        return redirect()
            ->route('cnas-morals.index')
            ->with('success', 'Compte CNAS Moral créé avec succès.');
    }
        public function edit(CnasMoral $cnas_moral)
    {
        $cnas_moral->load('beneficiaries');

        return view('cnas_morals.edit', compact('cnas_moral'));
    }

    public function update(Request $request, CnasMoral $cnas_moral)
    {
        $request->validate([

            'label_name' => 'required',
            'NIN' => 'required',
            'phone' => 'required',
            'code' => 'required',
            'mot_de_passe' => 'required',

            'prove_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'rent_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'G08_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'register_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cart_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'residence_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'Boal_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'rential_law_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'Nif_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'chek_baree_pdf' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',

        ]);

        $data = $request->only([

            'label_name',
            'NIN',
            'phone',
            'code',
            'mot_de_passe',

        ]);

        $files = [

            'prove_pdf',
            'rent_pdf',
            'G08_pdf',
            'register_pdf',
            'cart_pdf',
            'residence_pdf',
            'Boal_pdf',
            'rential_law_pdf',
            'Nif_pdf',
            'chek_baree_pdf',

        ];

        foreach ($files as $file) {

            if ($request->hasFile($file)) {

                if (
                    $cnas_moral->$file &&
                    Storage::disk('public')->exists($cnas_moral->$file)
                ) {
                    Storage::disk('public')->delete($cnas_moral->$file);
                }

                $data[$file] = $request
                    ->file($file)
                    ->store('cnas_morals', 'public');

            }

        }

        $cnas_moral->update($data);
                if ($request->has('beneficiaries')) {

            foreach ($request->beneficiaries as $beneficiary) {

                // =============================
                // Modifier un bénéficiaire existant
                // =============================

                if (!empty($beneficiary['id'])) {

                    $item = CnasMoralBeneficiary::find($beneficiary['id']);

                    if ($item) {

                        $beneficiaryData = [

                            'full_name' => $beneficiary['full_name'] ?? null,

                        ];

                        foreach ([
                            'cart_pdf',
                            'photo_pdf',
                            'residence_pdf'
                        ] as $file) {

                            if (
                                isset($beneficiary[$file]) &&
                                $beneficiary[$file] instanceof \Illuminate\Http\UploadedFile
                            ) {

                                if (
                                    $item->$file &&
                                    Storage::disk('public')->exists($item->$file)
                                ) {
                                    Storage::disk('public')->delete($item->$file);
                                }

                                $beneficiaryData[$file] = $beneficiary[$file]
                                    ->store('cnas_moral_beneficiaries', 'public');
                            }

                        }

                        $item->update($beneficiaryData);

                    }

                }

                // =============================
                // Ajouter un nouveau bénéficiaire
                // =============================

                else {

                    $beneficiaryData = [

                        'cnas_moral_id' => $cnas_moral->id,
                        'full_name' => $beneficiary['full_name'] ?? null,

                    ];

                    foreach ([
                        'cart_pdf',
                        'photo_pdf',
                        'residence_pdf'
                    ] as $file) {

                        if (
                            isset($beneficiary[$file]) &&
                            $beneficiary[$file] instanceof \Illuminate\Http\UploadedFile
                        ) {

                            $beneficiaryData[$file] = $beneficiary[$file]
                                ->store('cnas_moral_beneficiaries', 'public');

                        }

                    }

                    CnasMoralBeneficiary::create($beneficiaryData);

                }

            }

        }

        return redirect()
            ->route('cnas-morals.index')
            ->with('success', 'Compte modifié avec succès.');
    }
        public function destroy(CnasMoral $cnas_moral)
    {
        $companyFiles = [

            'prove_pdf',
            'rent_pdf',
            'G08_pdf',
            'register_pdf',
            'cart_pdf',
            'residence_pdf',
            'Boal_pdf',
            'rential_law_pdf',
            'Nif_pdf',
            'chek_baree_pdf',

        ];

        // حذف ملفات الشركة
        foreach ($companyFiles as $file) {

            if (
                $cnas_moral->$file &&
                Storage::disk('public')->exists($cnas_moral->$file)
            ) {
                Storage::disk('public')->delete($cnas_moral->$file);
            }

        }

        // حذف ملفات المستفيدين
        foreach ($cnas_moral->beneficiaries as $beneficiary) {

            foreach ([
                'cart_pdf',
                'photo_pdf',
                'residence_pdf'
            ] as $file) {

                if (
                    $beneficiary->$file &&
                    Storage::disk('public')->exists($beneficiary->$file)
                ) {
                    Storage::disk('public')->delete($beneficiary->$file);
                }

            }

        }

        // بفضل cascadeOnDelete سيتم حذف المستفيدين تلقائياً
        $cnas_moral->delete();

        return redirect()
            ->route('cnas-morals.index')
            ->with('success', 'Compte supprimé avec succès.');
    }

    public function deleteFile(CnasMoral $cnas_moral, $field)
    {
        $allowed = [

            'prove_pdf',
            'rent_pdf',
            'G08_pdf',
            'register_pdf',
            'cart_pdf',
            'residence_pdf',
            'Boal_pdf',
            'rential_law_pdf',
            'Nif_pdf',
            'chek_baree_pdf',

        ];

        if (!in_array($field, $allowed)) {
            abort(404);
        }

        if (
            $cnas_moral->$field &&
            Storage::disk('public')->exists($cnas_moral->$field)
        ) {
            Storage::disk('public')->delete($cnas_moral->$field);
        }

        $cnas_moral->update([
            $field => null,
        ]);

        return back()->with('success', 'Fichier supprimé avec succès.');
    }

    
    }