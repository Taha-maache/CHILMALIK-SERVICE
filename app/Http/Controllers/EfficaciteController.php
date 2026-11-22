<?php

namespace App\Http\Controllers;

use App\Models\Efficacite;
use Illuminate\Http\Request;

class EfficaciteController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;

    $efficacites = Efficacite::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->latest()
        ->get();

    return view('efficacites.index', compact('efficacites'));
}

    public function create()
    {
        return view('efficacites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'date_Paiment_fichier' => 'nullable|date',
        ]);

        Efficacite::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'date_Paiment_fichier' => $request->date_Paiment_fichier,
            'etat' => null,
        ]);

        return redirect()
            ->route('efficacites.index')
            ->with('success', 'تمت إضافة الملف بنجاح');
    }

    public function edit($id)
    {
        $efficacite = Efficacite::findOrFail($id);

        return view('efficacites.edit', compact('efficacite'));
    }

    public function update(Request $request, $id)
    {
        $efficacite = Efficacite::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'date_Paiment_fichier' => 'nullable|date',
        ]);

        $efficacite->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'date_Paiment_fichier' => $request->date_Paiment_fichier,
        ]);

        return redirect()
            ->route('efficacites.index')
            ->with('success', 'تم تعديل الملف بنجاح');
    }

    public function destroy($id)
    {
        $efficacite = Efficacite::findOrFail($id);

        $efficacite->delete();

        return redirect()
            ->route('efficacites.index')
            ->with('success', 'تم حذف الملف بنجاح');
    }

    public function updateEtat(Request $request, $id)
    {
        $efficacite = Efficacite::findOrFail($id);

        $request->validate([
            'etat' => 'nullable|in:transferer_au_ecole,recuperer_du_ecole,livrer_au_client',
        ]);

        $efficacite->update([
            'etat' => $request->etat,
        ]);

        return redirect()
            ->route('efficacites.index')
            ->with('success', 'تم تحديث الحالة بنجاح');
    }
}