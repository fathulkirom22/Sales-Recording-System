<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Item') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New Item')"
        :description="__('Fields: code, name, image (upload), price.')"
    >
        <p class="text-sm text-gray-500">{{ __('Form stub — implement next.') }}</p>
        <div class="mt-4">
            <a href="{{ route('items.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
