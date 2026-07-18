<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sales') }}</h2>

            <form method="GET" action="{{ route('sales.index') }}" class="flex flex-wrap items-end gap-2">
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

    <x-page-stub
        :title="__('Sales List')"
        :description="__('List of all sales.')"
        :create-route="route('sales.create')"
        :create-label="__('Add Sale')"
    >
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="sales-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Code') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Date') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Total') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Status') }}</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @if($sales->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                {{ __('No data yet. Implement Datatables binding.') }}
                            </td>
                        </tr>
                    @else
                        @foreach($sales as $sale)
                            <tr>
                                <td class="px-4 py-4 text-gray-700">{{ $sale->code }}</td>
                                <td class="px-4 py-4 text-gray-700">{{ date('d-m-Y', strtotime($sale->sale_date)) }}</td>
                                <td class="px-4 py-4 text-gray-700">Rp. {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-gray-700">{{ $sale->status->label() }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('sales.show', $sale) }}" class="text-blue-500 hover:text-blue-700">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </x-page-stub>
</x-app-layout>
