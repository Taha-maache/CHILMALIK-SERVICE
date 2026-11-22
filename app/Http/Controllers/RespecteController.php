<?php

namespace App\Http\Controllers;

use App\Models\Respecte;
use Illuminate\Http\Request;

class RespecteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $respectes = Respecte::query()
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('full_name_of_moussayer', 'like', '%' . $search . '%')
                      ->orWhere('phone_of_moussayer', 'like', '%' . $search . '%')
                      ->orWhere('resaux_social', 'like', '%' . $search . '%');

                });

            })
            ->latest()
            ->get();

        return view('respectes.index', compact('respectes'));
    }

    public function create()
    {
        return view('respectes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resaux_social' => 'nullable|string|max:255',

            'full_name_of_moussayer' =>
                'required|string|max:255',

            'phone_of_moussayer' =>
                'nullable|string|max:255',

            'date_of_this' =>
                'nullable|date',
        ]);

        Respecte::create($request->all());

        return redirect()
            ->route('respectes.index')
            ->with('success', 'تمت إضافة المعلومة بنجاح');
    }

    public function edit($id)
    {
        $respecte = Respecte::findOrFail($id);

        return view('respectes.edit', compact('respecte'));
    }

    public function update(Request $request, $id)
    {
        $respecte = Respecte::findOrFail($id);

        $request->validate([
            'resaux_social' => 'nullable|string|max:255',

            'full_name_of_moussayer' =>
                'required|string|max:255',

            'phone_of_moussayer' =>
                'nullable|string|max:255',

            'date_of_this' =>
                'nullable|date',
        ]);

        $respecte->update($request->all());

        return redirect()
            ->route('respectes.index')
            ->with('success', 'تم تعديل المعلومات بنجاح');
    }

    public function destroy($id)
    {
        $respecte = Respecte::findOrFail($id);

        $respecte->delete();

        return redirect()
            ->route('respectes.index')
            ->with('success', 'تم حذف المعلومات بنجاح');
    }
}