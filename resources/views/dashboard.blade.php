<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-end gap-2">
                <div>
                    <label for="date_from" class="block text-xs font-medium text-gray-500">{{ __('From') }}</label>
                    <input id="date_from" type="date" name="date_from" value="{{ $dateFrom }}"
                        class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <label for="date_to" class="block text-xs font-medium text-gray-500">{{ __('To') }}</label>
                    <input id="date_to" type="date" name="date_to" value="{{ $dateTo }}"
                        class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Filter') }}
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Widgets --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Transactions') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">0</p>
                    <p class="mt-1 text-xs text-gray-400">{{ __('Stub — wire up later') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Sales (Rp)') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">Rp 0</p>
                    <p class="mt-1 text-xs text-gray-400">{{ __('Stub — wire up later') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Qty Sold') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">0</p>
                    <p class="mt-1 text-xs text-gray-400">{{ __('Stub — wire up later') }}</p>
                </div>
            </div>

            {{-- Charts placeholders --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('Monthly Sales (Rp)') }}</h3>
                    <div class="mt-4 h-64 flex items-center justify-center border border-dashed border-gray-200 rounded-lg text-sm text-gray-400">
                        {{ __('Chart placeholder') }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('Item Sales Quantity') }}</h3>
                    <div class="mt-4 h-64 flex items-center justify-center border border-dashed border-gray-200 rounded-lg text-sm text-gray-400">
                        {{ __('Chart placeholder') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
