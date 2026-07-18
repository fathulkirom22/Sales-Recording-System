<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::all();
        return view('items.index', compact('items'));
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
