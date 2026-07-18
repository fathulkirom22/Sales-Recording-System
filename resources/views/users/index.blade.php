<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Users') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('User List')"
        :description="__('Master data for users.')"
        :create-route="route('users.create')"
        :create-label="__('Add User')"
    >
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="users-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Email') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Roles') }}</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                @if($users->isEmpty())
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                {{ __('No data yet.') }}
                            </td>
                        </tr>
                    </tbody>
                @else
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-4 text-left">{{ $user->name }}</td>
                                <td class="px-4 py-4 text-left">{{ $user->email }}</td>
                                <td class="px-4 py-4 text-left">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:underline">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </x-page-stub>
</x-app-layout>
