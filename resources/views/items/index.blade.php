<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Items') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('Item List')"
        :description="__('Master data for items.')"
        :create-route="route('items.create')"
        :create-label="__('Add Item')"
    >
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="items-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Code') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Price') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Image') }}</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @if($items->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                {{ __('No data yet.') }}
                            </td>
                        </tr>
                    @else
                        @foreach($items as $item)
                            <tr>
                                <td class="px-4 py-4 text-left">{{ $item->code }}</td>
                                <td class="px-4 py-4 text-left">{{ $item->name }}</td>
                                <td class="px-4 py-4 text-left">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-left">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover">
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('items.show', $item) }}" class="text-blue-500 hover:underline">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </x-page-stub>
</x-app-layout>
