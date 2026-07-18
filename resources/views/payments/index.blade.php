<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Payments') }}</h2>

            <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap items-end gap-2">
                <div>
                    <label for="date_from" class="block text-xs font-medium text-gray-500">{{ __('From') }}</label>
                    <input id="date_from" type="date" name="date_from" value="{{ $dateFrom }}"
                        class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <label for="date_to" class="block text-xs font-medium text-gray-500">{{ __('To') }}</label>
                    <input id="date_to" type="date" name="date_to" value="{{ $dateTo }}"
                        class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Filter') }}
                </button>
            </form>
        </div>
    </x-slot>

    <x-page-stub
        :title="__('Payment List')"
        :description="__('List of all payments.')"
        :create-route="route('payments.create')"
        :create-label="__('Add Payment')"
    >
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="payments-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Code') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Sale') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Amount') }}</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">{{ __('Date') }}</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @if($payments->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                {{ __('No data yet.') }}
                            </td>
                        </tr>
                    @else
                        @foreach($payments as $payment)
                            <tr>
                                <td class="px-4 py-4 text-gray-700">{{ $payment->code }}</td>
                                <td class="px-4 py-4 text-gray-700">{{ $payment->sale->code }}</td>
                                <td class="px-4 py-4 text-gray-700">{{ $payment->amount }}</td>
                                <td class="px-4 py-4 text-gray-700">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('payments.show', $payment) }}" class="text-blue-600 hover:text-blue-800">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </x-page-stub>
</x-app-layout>
