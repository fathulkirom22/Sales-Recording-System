<?php

namespace App\Http\Controllers;

use App\Enums\SaleStatus;
use App\Models\Sale;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Support\CodeGenerator;

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
    public function index(Request $request): View|JsonResponse
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($request->ajax()) {
            $query = Sale::query()
                ->when($dateFrom, function ($query, $dateFrom) {
                    $query->whereDate('sale_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query, $dateTo) {
                    $query->whereDate('sale_date', '<=', $dateTo);
                })
                ->latest();

            return DataTables::eloquent($query)
                ->editColumn('sale_date', fn (Sale $sale) => $sale->sale_date?->format('d-m-Y'))
                ->editColumn('total_amount', fn (Sale $sale) => 'Rp. ' . number_format((float) $sale->total_amount, 0, ',', '.'))
                ->editColumn('status', fn (Sale $sale) => $sale->status->label())
                ->addColumn('actions', fn (Sale $sale) => '<a href="' . route('sales.show', $sale) . '" class="text-blue-500 hover:text-blue-700">' . __('View') . '</a>')
                ->rawColumns(['actions'])
                ->toJson();
        }

        return view('sales.index', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
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
            'code' => CodeGenerator::next(Sale::class, 'SALE'),
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
