<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sale Detail') }}: {{ $sale->code }}</h2>
    </x-slot>

    <x-page-stub :title="$sale->code">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-gray-500">{{ __('Date') }}</dt>
                <dd class="font-medium">{{ $sale->sale_date?->format('Y-m-d') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Status') }}</dt>
                <dd class="font-medium">{{ $sale->status->label() }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Total Amount') }}</dt>
                <dd class="font-medium">Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Created By') }}</dt>
                <dd class="font-medium">{{ $sale->user?->name }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-4">
            @if ($sale->isEditable())
                <a href="{{ route('sales.edit', $sale) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
            @endif
            <a href="{{ route('sales.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
