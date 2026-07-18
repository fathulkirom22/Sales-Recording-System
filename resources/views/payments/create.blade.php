<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Payment') }}</h2>
    </x-slot>

    <x-page-stub
        :title="__('New Payment')"
        :description="__('Auto-generate payment code. Link to one sale. Support partial payments (status becomes Not Fully Paid).')"
    >
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="mt-4">
                <label for="sale_id" class="block text-sm font-medium text-gray-700">{{ __('Sale') }}</label>
                <select id="sale_id" name="sale_id" class="mt-1 block w-full" required>
                    <option value="" disabled {{ old('sale_id') ? '' : 'selected' }}>{{ __('Select a sale') }}</option>
                    @foreach ($sales as $sale)
                        <option value="{{ $sale->id }}" {{ (string) old('sale_id') === (string) $sale->id ? 'selected' : '' }}>{{ $sale->code }} (Rp {{ number_format($sale->total_amount, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('Amount') }}</label>
                <input type="text" id="amount" name="amount" value="{{ old('amount') }}" class="mt-1 block w-full" required>
            </div>
            <div class="mt-4">
                <label for="note" class="block text-sm font-medium text-gray-700">{{ __('Note') }}</label>
                <textarea id="note" name="notes" class="mt-1 block w-full" required>{{ old('note') }}</textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Submit Payment') }}</button>
            </div>
        </form>
        <div class="mt-4">
            <a href="{{ route('payments.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
