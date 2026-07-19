<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Items') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('Item List')"
        :description="__('Master data for items.')"
        :create-route="Auth::user()->can('items.create') ? route('items.create') : null"
        :create-label="__('Add Item')"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="items-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Code') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Price') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Image') }}</th>
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
                $('#items-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('items.index') }}',
                    columns: [
                        { data: 'code', name: 'code' },
                        { data: 'name', name: 'name' },
                        { data: 'price', name: 'price' },
                        { data: 'image', name: 'image', orderable: false, searchable: false },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        { targets: [2, 4], className: 'dt-body-right' } // kolom 2 rata kanan
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
