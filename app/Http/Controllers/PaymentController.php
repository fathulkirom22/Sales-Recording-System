<?php

namespace App\Http\Controllers;

use App\Enums\SaleStatus;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PaymentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:payments.view', only: ['index', 'show']),
            new Middleware('permission:payments.create', only: ['create', 'store']),
            new Middleware('permission:payments.update', only: ['edit', 'update']),
            new Middleware('permission:payments.delete', only: ['destroy']),
        ];
    }
    public function index(Request $request): View
    {
        // TODO: Datatables + date filter
        $payments = Payment::query()
            ->when($request->input('date_from'), function ($query, $dateFrom) {
                $query->where('created_at', '>=', $dateFrom);
            })
            ->when($request->input('date_to'), function ($query, $dateTo) {
                $query->where('created_at', '<=', $dateTo);
            })
            ->latest()
            ->get();
        return view('payments.index', [
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
            'payments' => $payments,
        ]);
    }

    public function create(): View
    {
        // TODO: form linked to one sale, support partial payments
        $sales = Sale::where('status', '!=', 'paid')->get();
        return view('payments.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'required|string',
        ]);

        $sale = Sale::findOrFail($validated['sale_id']);
        if ($sale->status === SaleStatus::Paid) {
            return redirect()->back()->withErrors(['sale_id' => 'This sale is already fully paid.']);
        }

        $paidAmount = $sale->payments()->sum('amount');
        $remainingAmount = $sale->total_amount - $paidAmount;
        if ($validated['amount'] > $remainingAmount) {
            return redirect()->back()->withErrors([
                'amount' => 'Payment amount exceeds remaining balance. Total: Rp. ' . number_format($sale->total_amount, 2) . ', Paid: Rp. ' . number_format($paidAmount, 2) . ', Remaining: Rp. ' . number_format($remainingAmount, 2),
            ]);
        }

        Payment::create([
            'code' => 'PAY-' . strtoupper(uniqid()),
            'sale_id' => $sale->id,
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'payment_date' => now(),
            'notes' => $validated['notes'],
        ]);

        $sale->recalculateStatus();

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment): View
    {
        $payment->load(['sale', 'user']);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment): View
    {
        // Linked sale cannot be changed on edit
        $payment->load('sale');

        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'required|string',
        ]);

        $sale = $payment->sale;

        $otherPaidAmount = $sale->payments()->where('id', '!=', $payment->id)->sum('amount');
        $remainingAmount = $sale->total_amount - $otherPaidAmount;
        if ($validated['amount'] > $remainingAmount) {
            return redirect()->back()->withErrors(['amount' => 'Payment amount exceeds remaining balance. Total: Rp. ' . number_format($sale->total_amount, 2) . ', Paid: Rp. ' . number_format($otherPaidAmount, 2) . ', Remaining: Rp. ' . number_format($remainingAmount, 2)]);
        }

        $payment->update($validated);

        $sale->recalculateStatus();

        return redirect()->route('payments.show', $payment)->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $sale = $payment->sale;

        $payment->delete();

        $sale->recalculateStatus();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
