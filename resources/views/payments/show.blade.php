<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Payment Detail') }}: {{ $payment->code }}</h2>
    </x-slot>

    <x-page-stub :title="$payment->code">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-gray-500">{{ __('Sale') }}</dt>
                <dd class="font-medium">
                    <a href="{{ route('sales.show', $payment->sale) }}">{{ $payment->sale?->code }} - {{ $payment->sale?->status->label() }}</a></dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Amount') }}</dt>
                <dd class="font-medium">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Date') }}</dt>
                <dd class="font-medium">{{ $payment->payment_date?->format('Y-m-d') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Recorded By') }}</dt>
                <dd class="font-medium">{{ $payment->user?->name }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('Notes') }}</dt>
                <dd class="font-medium">{{ $payment->notes }}</dd>
            </div>

        </dl>

        <div class="mt-6 flex gap-4 items-center">
            @can('payments.update')
                <a href="{{ route('payments.edit', $payment) }}" class="text-sm text-indigo-600 hover:underline">{{ __('Edit') }}</a>
            @endcan
            @can('payments.delete')
                <!-- Delete button -->
                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this payment?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
                </form>
            @endcan
            <a href="{{ route('payments.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
