<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Item') }}: {{ $item->code }}</h2>
    </x-slot>

    <x-page-stub
        :title="$item->name"
        :description="__('Update code, name, image, and price.')"
    >
        <p class="text-sm text-gray-500">{{ __('Price') }}: Rp {{ number_format((float) $item->price, 0, ',', '.') }}</p>
        <div class="mt-4">
            <a href="{{ route('items.show', $item) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
