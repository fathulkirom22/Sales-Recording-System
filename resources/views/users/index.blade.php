<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Users') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('User List')"
        :description="__('Master data for users.')"
        :create-route="Auth::user()->can('users.create') ? route('users.create') : null"
        :create-label="__('Add User')"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="users-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Email') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Roles') }}</th>
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
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('users.index') }}',
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'roles', name: 'roles', orderable: false, searchable: false },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        { targets: [3], className: 'dt-body-right' } // kolom 2 rata kanan
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
