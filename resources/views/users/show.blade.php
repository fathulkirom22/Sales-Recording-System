<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('User Detail') }}: {{ $user->name }}</h2>
    </x-slot>

    <x-page-stub :title="$user->name">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-gray-500">{{ __('Email') }}</dt>
                <dd class="font-medium">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Roles') }}</dt>
                <dd class="font-medium">{{ $user->getRoleNames()->join(', ') ?: '—' }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-4 align-middle items-center">
            <a href="{{ route('users.edit', $user) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
            </form>
            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
