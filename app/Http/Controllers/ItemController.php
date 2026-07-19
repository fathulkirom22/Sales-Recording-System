<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:items.view', only: ['index', 'show']),
            new Middleware('permission:items.create', only: ['create', 'store']),
            new Middleware('permission:items.update', only: ['edit', 'update']),
            new Middleware('permission:items.delete', only: ['destroy']),
        ];
    }
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::eloquent(Item::query())
                ->editColumn('price', fn (Item $item) => 'Rp ' . number_format((float) $item->price, 0, ',', '.'))
                ->addColumn('image', fn (Item $item) => $item->image ? '<img src="' . asset('storage/' . $item->image) . '" alt="' . e($item->name) . '" class="w-10 h-10 object-cover">' : '')
                ->addColumn('actions', fn (Item $item) => '<a href="' . route('items.show', $item) . '" class="text-blue-500 hover:underline">' . __('View') . '</a>')
                ->rawColumns(['image', 'actions'])
                ->toJson();
        }

        return view('items.index');
    }

    public function create(): View
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        // store code, name, image, price
        $validated = $request->validate([
            'code' => 'required|unique:items',
            'name' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
        ]);

        // store image in storage/app/public/images
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $item = new Item();
        $item->fill($validated);
        $item->save();
        return redirect()->route('items.show', $item)->with('success', 'Item created successfully.');
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
        // update item + optional image replace
        $validated = $request->validate([
            'code' => 'required|unique:items,code,' . $item->id,
            'name' => 'required',
            'image' => 'image',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $item->fill(array_filter($validated, fn($value) => $value !== null));
        $item->save();
        return redirect()->route('items.show', $item)->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        // delete item
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
