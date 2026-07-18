<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Payment') }}: {{ $payment->code }}</h2>
    </x-slot>

    <x-page-stub
        :title="$payment->code"
        :description="__('Linked sale cannot be changed. Recalculate sale status after update.')"
    >
        <p class="text-sm text-gray-500">{{ __('Sale') }}: {{ $payment->sale?->code }}</p>
        <div class="mt-4">
            <a href="{{ route('payments.show', $payment) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
