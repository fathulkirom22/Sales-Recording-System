<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Payment') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New Payment')"
        :description="__('Auto-generate payment code. Link to one sale. Support partial payments (status becomes Not Fully Paid).')"
    >
        <p class="text-sm text-gray-500">{{ __('Form stub — implement next.') }}</p>
        <div class="mt-4">
            <a href="{{ route('payments.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
