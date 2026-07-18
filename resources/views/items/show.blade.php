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
            <div>
                <dt class="text-gray-500">{{ __('Image') }}</dt>
                <dd class="font-medium"><img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover"></dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-4 items-center">
            <a href="{{ route('items.edit', $item) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
            <!-- Delete button -->
            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this item?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
            </form>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
