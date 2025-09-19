<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments for the authenticated landlord's properties.
     */
    public function index()
    {
        $payments = Payment::with(['lease.unit.property'])
            ->whereHas('lease.unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('landlord.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $leases = Lease::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->with(['unit', 'tenant'])->get();

        return view('landlord.payments.create', compact('leases'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lease_id' => [
                'required',
                'integer',
                Rule::exists('leases', 'id')->where(function ($query) {
                    $query->whereHas('unit.property', function ($q) {
                        $q->where('landlord_id', Auth::id());
                    });
                }),
            ],
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,check,bank_transfer,card',
            'status' => 'required|in:pending,completed,failed',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment = Payment::create($request->only([
            'lease_id', 'amount', 'payment_date',
            'method', 'status', 'notes'
        ]));

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['lease.unit.property', 'lease.tenant'])
            ->whereHas('lease.unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->findOrFail($id);

        return view('landlord.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = Payment::whereHas('lease.unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $leases = Lease::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->with(['unit', 'tenant'])->get();

        return view('landlord.payments.edit', compact('payment', 'leases'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::whereHas('lease.unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $request->validate([
            'lease_id' => [
                'required',
                'integer',
                Rule::exists('leases', 'id')->where(function ($query) {
                    $query->whereHas('unit.property', function ($q) {
                        $q->where('landlord_id', Auth::id());
                    });
                }),
            ],
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,check,bank_transfer,card',
            'status' => 'required|in:pending,completed,failed',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update($request->only([
            'lease_id', 'amount', 'payment_date',
            'method', 'status', 'notes'
        ]));

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        $payment = Payment::whereHas('lease.unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }

    /**
     * Record a new payment for a specific lease.
     */
    public function pay(Request $request, $leaseId)
    {
        $lease = Lease::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($leaseId);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,check,bank_transfer,card',
        ]);

        $payment = Payment::create([
            'lease_id' => $lease->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Payment recorded successfully!');
    }
}
