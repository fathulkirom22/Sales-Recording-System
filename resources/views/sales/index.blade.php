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
        :create-route="Auth::user()->can('sales.create') ? route('sales.create') : null"
        :create-label="__('Add Sale')"
    >
        <div class="overflow-x-auto">
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
                <tbody class="divide-y divide-gray-100 bg-white"></tbody>
            </table>
        </div>
    </x-page-stub>

    @push('scripts')
        <script>
            $(function () {
                $('#sales-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('sales.index', array_filter(['date_from' => $dateFrom, 'date_to' => $dateTo])) }}',
                    columns: [
                        { data: 'code', name: 'code' },
                        { data: 'sale_date', name: 'sale_date' },
                        { data: 'total_amount', name: 'total_amount' },
                        { data: 'status', name: 'status' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false, align: 'right' },
                    ],
                    columnDefs: [
                        { targets: [2, 4], className: 'dt-body-right' } // kolom 0 & 1 rata kanan
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
