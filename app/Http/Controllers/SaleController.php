<?php

namespace App\Http\Controllers;

use App\Enums\SaleStatus;
use App\Models\Sale;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class SaleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:sales.view', only: ['index', 'show']),
            new Middleware('permission:sales.create', only: ['create', 'store']),
            new Middleware('permission:sales.update', only: ['edit', 'update']),
            new Middleware('permission:sales.delete', only: ['destroy']),
        ];
    }
    public function index(Request $request): View
    {
        // Datatables + date filter
        $sales = Sale::query()
            ->when($request->input('date_from'), function ($query, $dateFrom) {
                $query->whereDate('sale_date', '>=', $dateFrom);
            })
            ->when($request->input('date_to'), function ($query, $dateTo) {
                $query->whereDate('sale_date', '<=', $dateTo);
            })
            ->latest()
            ->get();
        return view('sales.index', [
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
            'sales' => $sales,
        ]);
    }

    public function create(): View
    {
        $items = Item::all();
        return view('sales.create', compact('items'));
    }

    public function store(Request $request)
    {
        // create sale + sale items, default status Unpaid
        $request->validate([
            'item' => 'required|array',
            'quantity' => 'required|array',
        ]);
        $sale = new Sale();
        $sale->fill([
            'code' => strtoupper(uniqid()),
            'user_id' => auth()->id(),
            'sale_date' => now(),
            'status' => SaleStatus::Unpaid,
        ]);
        $sale->save();
        $total_amount = 0;
        foreach ($request->input('item') as $index => $itemId) {
            $item = Item::findOrFail($itemId);
            $total_price = $item->price * $request->input('quantity')[$index];
            $sale->items()->create([
                'item_id' => $itemId,
                'sale_id' => $sale->id,
                'qty' => $request->input('quantity')[$index],
                'price' => $item->price,
                'total_price' => $total_price,
            ]);
            $total_amount += $total_price;
        }
        $sale->total_amount = $total_amount;
        $sale->save();
        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
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
        $items = Item::all();

        return view('sales.edit', compact('sale', 'items'));
    }

    public function update(Request $request, Sale $sale)
    {
        abort_unless($sale->isEditable(), 403, 'Paid sales cannot be edited.');

        $request->validate([
            'item' => 'required|array',
            'quantity' => 'required|array',
        ]);

        $sale->items()->delete();

        $total_amount = 0;
        foreach ($request->input('item') as $index => $itemId) {
            $item = Item::findOrFail($itemId);
            $qty = $request->input('quantity')[$index];
            $total_price = $item->price * $qty;
            $sale->items()->create([
                'item_id' => $itemId,
                'qty' => $qty,
                'price' => $item->price,
                'total_price' => $total_price,
            ]);
            $total_amount += $total_price;
        }

        $sale->total_amount = $total_amount;
        $sale->save();

        return redirect()->route('sales.show', $sale)->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        abort_unless($sale->isEditable(), 403, 'Paid sales cannot be deleted.');
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
