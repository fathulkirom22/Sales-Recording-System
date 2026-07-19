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

        <!-- Items -->
        <dl>
            <dt class="text-gray-500 mb-0">{{ __('Items') }}</dt>
            <div class="mt-0 overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-500">{{ __('Item') }}</th>
                            <th class="px-4 py-2 text-left text-gray-500">{{ __('Quantity') }}</th>
                            <th class="px-4 py-2 text-left text-gray-500">{{ __('Price') }}</th>
                            <th class="px-4 py-2 text-left text-gray-500">{{ __('Total Price') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sale->items as $item)
                        <tr>
                            <td class="px-4 py-2 text-gray-700">{{ $item->item->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $item->qty }}</td>
                            <td class="px-4 py-2 text-gray-700">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-gray-700">Rp {{ number_format((float) $item->qty * $item->price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </dl>

        <!-- Payments -->
        @if($sale->payments->isNotEmpty())
            <dl>
                <dt class="text-gray-500 mb-0">{{ __('Payments') }}</dt>
                <div class="mt-0 overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-500">{{ __('Code') }}</th>
                                <th class="px-4 py-2 text-left text-gray-500">{{ __('Amount') }}</th>
                                <th class="px-4 py-2 text-left text-gray-500">{{ __('Payment Date') }}</th>
                                <th class="px-4 py-2 text-left text-gray-500">{{ __('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sale->payments as $payment)
                            <tr>
                                <td class="px-4 py-2 text-gray-700">{{ $payment->code }}</td>
                                <td class="px-4 py-2 text-gray-700">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $payment->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </dl>
        @endif

        <div class="mt-6 flex gap-4 items-center">
            @if ($sale->isEditable())
                @can('sales.update')
                    <a href="{{ route('sales.edit', $sale) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
                @endcan
                @can('sales.delete')
                    <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this sale?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
                    </form>
                @endcan
            @endif
            <a href="{{ route('sales.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
