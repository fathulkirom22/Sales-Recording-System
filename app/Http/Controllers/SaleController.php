<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        // TODO: Datatables + date filter
        return view('sales.index', [
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
        ]);
    }

    public function create(): View
    {
        // TODO: form with multi-item rows, auto-generated code
        return view('sales.create');
    }

    public function store(Request $request)
    {
        // TODO: create sale + sale items, default status Unpaid
        abort(501);
    }

    public function show(Sale $sale): View
    {
        $sale->load(['items.item', 'payments', 'user']);

        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        abort_unless($sale->isEditable(), 403, 'Paid sales cannot be edited.');

        $sale->load(['items.item']);

        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        // TODO: update sale items when not paid
        abort(501);
    }

    public function destroy(Sale $sale)
    {
        // TODO: prevent delete when paid
        abort(501);
    }
}
