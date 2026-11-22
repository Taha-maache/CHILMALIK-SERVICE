<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\CreditPayment;
use Illuminate\Http\Request;

class CreditPaymentController extends Controller
{
    public function index(Credit $credit)
    {
        $payments = $credit->payments()
            ->latest('payment_date')
            ->get();

        return view(
            'credits.payments',
            compact('credit','payments')
        );
    }

    public function store(Request $request, Credit $credit)
    {
        $request->validate([
            'amount'=>'required|numeric|min:1',
            'payment_date'=>'required|date',
            'note'=>'nullable|string'
        ]);

        $credit->payments()->create([
            'amount'=>$request->amount,
            'payment_date'=>$request->payment_date,
            'note'=>$request->note,
        ]);

        return back()->with('success','Paiement ajouté.');
    }

    public function destroy(CreditPayment $payment)
    {
        $payment->delete();

        return back()->with('success','Paiement supprimé.');
    }
}