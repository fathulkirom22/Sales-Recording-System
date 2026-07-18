<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Item') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New Item')"
        :description="__('Fields: code, name, image (upload), price.')"
    >
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-4">
                <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                <input type="text" id="code" name="code" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                <input type="number" id="price" name="price" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">{{ __('Save') }}</button>
            </div>
        </form>
        <div class="mt-4">
            <a href="{{ route('items.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
