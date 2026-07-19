<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:dashboard.view'),
        ];
    }
    public function __invoke(Request $request): View
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());

        $sales = Sale::query()
            ->whereDate('sale_date', '>=', $dateFrom)
            ->whereDate('sale_date', '<=', $dateTo)
            ->with('items.item')
            ->get();

        $saleItems = $sales->flatMap(fn (Sale $sale) => $sale->items);

        $totalTransactions = $sales->count();
        $totalSales = $sales->sum('total_amount');
        $totalQty = $saleItems->sum('qty');

        $monthlySales = $sales
            ->groupBy(fn (Sale $sale) => $sale->sale_date->format('Y-m'))
            ->map(fn ($group) => $group->sum('total_amount'))
            ->sortKeys();

        $itemSales = $saleItems
            ->groupBy(fn ($saleItem) => $saleItem->item?->name ?? 'Unknown')
            ->map(fn ($group) => $group->sum('qty'))
            ->sortDesc()
            ->take(10);

        return view('dashboard', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'totalTransactions' => $totalTransactions,
            'totalSales' => $totalSales,
            'totalQty' => $totalQty,
            'monthlyLabels' => $monthlySales->keys()->values(),
            'monthlyValues' => $monthlySales->values()->values(),
            'itemLabels' => $itemSales->keys()->values(),
            'itemValues' => $itemSales->values()->values(),
        ]);
    }
}
