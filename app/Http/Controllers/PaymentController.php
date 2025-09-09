<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        return Payment::with('lease')->get();
    }

    public function store(Request $request) {
        return Payment::create($request->all());
    }

    public function show($id) {
        return Payment::with('lease')->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return $payment;
    }

    public function destroy($id) {
        return Payment::destroy($id);
    }

    // Custom method for rent payment
    public function pay(Request $request, Lease $lease) {
        $payment = Payment::create([
            'lease_id' => $lease->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'payment_date' => now(),
            'status' => 'completed'
        ]);
        return response()->json($payment, 201);
    }
}
