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
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalTransactions) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Sales (Rp)') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">Rp {{ number_format((float) $totalSales, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Qty Sold') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalQty) }}</p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('Monthly Sales (Rp)') }}</h3>
                    <div class="mt-4 h-64">
                        @if ($monthlyLabels->isEmpty())
                            <div class="h-full flex items-center justify-center border border-dashed border-gray-200 rounded-lg text-sm text-gray-400">
                                {{ __('No data for the selected period.') }}
                            </div>
                        @else
                            <canvas id="monthlySalesChart"></canvas>
                        @endif
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('Item Sales Quantity') }}</h3>
                    <div class="mt-4 h-64">
                        @if ($itemLabels->isEmpty())
                            <div class="h-full flex items-center justify-center border border-dashed border-gray-200 rounded-lg text-sm text-gray-400">
                                {{ __('No data for the selected period.') }}
                            </div>
                        @else
                            <canvas id="itemSalesChart"></canvas>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const monthlyCanvas = document.getElementById('monthlySalesChart');
                if (monthlyCanvas) {
                    new Chart(monthlyCanvas, {
                        type: 'line',
                        data: {
                            labels: @json($monthlyLabels),
                            datasets: [{
                                label: '{{ __('Sales (Rp)') }}',
                                data: @json($monthlyValues),
                                borderColor: 'rgb(79, 70, 229)',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                tension: 0.3,
                                fill: true,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } },
                        },
                    });
                }

                const itemCanvas = document.getElementById('itemSalesChart');
                if (itemCanvas) {
                    new Chart(itemCanvas, {
                        type: 'bar',
                        data: {
                            labels: @json($itemLabels),
                            datasets: [{
                                label: '{{ __('Qty Sold') }}',
                                data: @json($itemValues),
                                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } },
                        },
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
