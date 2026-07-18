<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Sale') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New Sale')"
        :description="__('Auto-generate sale code. Support multiple items with qty, price, and total. Default status: Unpaid.')"
    >
        <form method="POST" action="{{ route('sales.store') }}" x-data="{ rows: [{ id: 1 }], nextId: 2 }">
            @csrf
            <template x-for="(row, index) in rows" :key="row.id">
                <div class="flex w-full gap-4 items-end">
                    <div class="mt-4">
                        <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Item') }}</label>
                        <select id="item" name="item[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="" disabled selected>{{ __('Select an item') }}</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Rp. {{ number_format((float) $item->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">{{ __('Quantity') }}</label>
                        <input type="number" id="quantity" name="quantity[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="mt-4">
                        <button type="button" @click="rows.length > 1 && rows.splice(index, 1)" x-show="rows.length > 1" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">&times; {{ __('Remove') }}</button>
                    </div>
                </div>
            </template>
            <div class="mt-4 flex gap-4">
                <button type="button" @click="rows.push({ id: nextId++ })" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">+ {{ __('Add Item') }}</button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Save') }}</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('sales.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
