<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Sale') }}: {{ $sale->code }}</h2>
    </x-slot>

    <x-page-stub
        :title="$sale->code"
        :description="__('Paid sales cannot be edited. Implement item/qty updates next.')"
    >
        <p class="text-sm text-gray-500">{{ __('Status') }}: {{ $sale->status->label() }}</p>
        <div class="mt-4">
            <a href="{{ route('sales.show', $sale) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
