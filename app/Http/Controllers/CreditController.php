<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Service;
class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $credits = Credit::with('service')->latest()->get();

    return view('credits.index', compact('credits'));
}

    /**
     * Show the form for creating a new resource.
     */

    public function create(Service $service)
    {
        return view('credits.create', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request, Service $service)
{
    $request->validate([
        'amount_paid' => 'required|numeric|min:0'
    ]);

    $credit = Credit::create([
        'service_id' => $service->id,
        'amount_paid' => 0, // ما بقيناش نستعملوه
    ]);

    $credit->payments()->create([
        'amount' => $request->amount_paid,
        'payment_date' => now()->toDateString(),
    ]);

    return redirect()->route('credits.index');
}

    /**
     * Display the specified resource.
     */
public function show(Credit $credit)
{
    $credit->load('service','payments');

    return view('credits.show',compact('credit'));
}
    /**
     * Show the form for editing the specified resource.
     */
 public function edit(Credit $credit)
{
    return view('credits.edit', compact('credit'));
}

public function update(Request $request, Credit $credit)
{
    $request->validate([
        'amount_paid' => 'required|numeric'
    ]);

    $credit->update([
        'amount_paid' => $request->amount_paid
    ]);

    return redirect()->route('credits.index');
}
    /**
     * Remove the specified resource from storage.
     */
 public function destroy(Credit $credit)
{
    $credit->delete();

    return redirect()->route('credits.index');
}
}
