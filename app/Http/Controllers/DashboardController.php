<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        // TODO: wire widgets/charts using date range filter
        return view('dashboard', [
            'dateFrom' => $request->input('date_from', now()->startOfMonth()->toDateString()),
            'dateTo' => $request->input('date_to', now()->toDateString()),
        ]);
    }
}
