<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        // TODO: Datatables + date filter
        return view('payments.index', [
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
        ]);
    }

    public function create(): View
    {
        // TODO: form linked to one sale, support partial payments
        return view('payments.create');
    }

    public function store(Request $request)
    {
        // TODO: create payment, update sale status, validate amount
        abort(501);
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
        // TODO: update payment details, recalculate sale status
        abort(501);
    }

    public function destroy(Payment $payment)
    {
        // TODO: delete payment and revert sale status
        abort(501);
    }
}
