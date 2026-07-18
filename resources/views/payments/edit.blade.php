<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Payment') }}: {{ $payment->code }}</h2>
    </x-slot>

    <x-page-stub
        :title="$payment->code"
        :description="__('Linked sale cannot be changed. Recalculate sale status after update.')"
    >
        <p class="text-sm text-gray-500">{{ __('Sale') }}: {{ $payment->sale?->code }}</p>

        <form method="POST" action="{{ route('payments.update', $payment) }}">
            @csrf
            @method('PUT')
            <div class="mt-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('Amount') }}</label>
                <input type="text" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <label for="note" class="block text-sm font-medium text-gray-700">{{ __('Note') }}</label>
                <textarea id="note" name="notes" class="mt-1 block w-full" required>{{ old('notes', $payment->notes) }}</textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Submit Payment') }}</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('payments.show', $payment) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to detail') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
