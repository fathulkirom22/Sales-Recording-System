<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Item') }}: {{ $item->code }}</h2>
    </x-slot>

    <x-page-stub
        :title="$item->name"
        :description="__('Update code, name, image, and price.')"
    >
        <form method="POST" action="{{ route('items.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mt-4">
                <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                <input type="text" name="code" id="code" class="mt-1 block w-full" value="{{ $item->code }}" required>
            </div>
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full" value="{{ $item->name }}" required>
            </div>
            <div class="mt-4">
                <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                <input type="number" name="price" id="price" class="mt-1 block w-full" value="{{ $item->price }}" required>
            </div>
            <div class="mt-4">
                <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full" value="{{ $item->image }}">
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">{{ __('Update') }}</button>
            </div>
        </form>
        <div class="mt-4">
            <a href="{{ route('items.show', $item) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
