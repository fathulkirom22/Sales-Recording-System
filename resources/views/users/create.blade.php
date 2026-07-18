<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add User') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New User')"
        :description="__('Fields: name, email, password, role.')"
    >
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                <select id="role" name="role" class="mt-1 block w-full" required>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">{{ __('Create') }}</button>
            </div>
        </form>
        <p class="text-sm text-gray-500">{{ __('Form stub — implement next.') }}</p>
        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
