@props(['title', 'description' => null, 'createRoute' => null, 'createLabel' => null])

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                        @if ($description)
                            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                        @endif
                    </div>

                    @if ($createRoute)
                        <a href="{{ $createRoute }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ $createLabel ?? __('Create') }}
                        </a>
                    @endif
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
