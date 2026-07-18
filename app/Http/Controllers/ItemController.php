<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        // TODO: Datatables list
        return view('items.index');
    }

    public function create(): View
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        // TODO: store code, name, image, price
        abort(501);
    }

    public function show(Item $item): View
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        // TODO: update item + optional image replace
        abort(501);
    }

    public function destroy(Item $item)
    {
        // TODO: delete item
        abort(501);
    }
}
