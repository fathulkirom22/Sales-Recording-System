<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Sale') }}</h2>
    </x-slot>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-page-stub
        :title="__('New Sale')"
        :description="__('Auto-generate sale code. Support multiple items with qty, price, and total. Default status: Unpaid.')"
    >
        <p class="text-sm text-gray-500">{{ __('Form stub — implement multi-item rows next.') }}</p>
        <div class="mt-4">
            <a href="{{ route('sales.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-page-stub>
</x-app-layout>
