<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit User') }}: {{ $user->name }}</h2>
    </x-slot>

    <x-page-stub
        :title="$user->name"
        :description="__('Update name, email, password, and roles.')"
    >
        <p class="text-sm text-gray-500">{{ $user->email }}</p>

        <!-- Form -->
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full" placeholder="*****">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                <select id="role" name="role" class="mt-1 block w-full" required>
                    <option value="staff" {{ in_array('staff', $user->getRoleNames()->toArray()) ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ in_array('admin', $user->getRoleNames()->toArray()) ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Save') }}</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('users.show', $user) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
