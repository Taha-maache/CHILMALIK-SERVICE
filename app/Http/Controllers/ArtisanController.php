<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function index()
    {
        $artisans = Artisan::latest()->get();

        return view('artisans.index', compact('artisans'));
    }

    public function create()
    {
        return view('artisans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'NIN' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'number_of_registration' => 'nullable|string|max:255',
            'number_of_casnos' => 'nullable|string|max:255',
        ]);

        Artisan::create([
            'full_name' => $request->full_name,
            'NIN' => $request->NIN,
            'phone' => $request->phone,
            'number_of_registration' => $request->number_of_registration,
            'number_of_casnos' => $request->number_of_casnos,

            // الحالة تبدأ فارغة
            'etat' => null,
        ]);

        return redirect()
            ->route('artisans.index')
            ->with('success', 'تمت إضافة الحرفي بنجاح');
    }

    public function edit($id)
    {
        $artisan = Artisan::findOrFail($id);

        return view('artisans.edit', compact('artisan'));
    }

    public function update(Request $request, $id)
    {
        $artisan = Artisan::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'NIN' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'number_of_registration' => 'nullable|string|max:255',
            'number_of_casnos' => 'nullable|string|max:255',
        ]);

        $artisan->update([
            'full_name' => $request->full_name,
            'NIN' => $request->NIN,
            'phone' => $request->phone,
            'number_of_registration' => $request->number_of_registration,
            'number_of_casnos' => $request->number_of_casnos,
        ]);

        return redirect()
            ->route('artisans.index')
            ->with('success', 'تم تعديل بيانات الحرفي بنجاح');
    }

    public function destroy($id)
    {
        $artisan = Artisan::findOrFail($id);

        $artisan->delete();

        return redirect()
            ->route('artisans.index')
            ->with('success', 'تم حذف الحرفي بنجاح');
    }

    /*
    |--------------------------------------------------------------------------
    | تغيير الحالة من Action فقط
    |--------------------------------------------------------------------------
    */

public function updateEtat(Request $request, $id)
{
    $artisan = Artisan::findOrFail($id);

    $request->validate([
        'etat' => 'nullable|in:transfere_au_char,recuperer_du_char,livrer_au_client',
    ]);

    $artisan->update([
        'etat' => $request->etat,
    ]);

    return redirect()
        ->route('artisans.index')
        ->with('success', 'تم تحديث الحالة بنجاح');
}
}