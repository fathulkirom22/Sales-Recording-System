<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Item Detail') }}: {{ $item->code }}</h2>
    </x-slot>

    <x-page-stub :title="$item->name">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-gray-500">{{ __('Code') }}</dt>
                <dd class="font-medium">{{ $item->code }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Price') }}</dt>
                <dd class="font-medium">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('items.edit', $item) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
