<div class="grid grid-cols-2 gap-4">
    @if ($getState() != null)
        @foreach ($getState() as $invoice)
            <a href="invoices/{{$invoice->id}}" class="flex items-center justify-between px-4 py-1 mb-2">
                <div class="flex items-right pl-2">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-eye"
                        wire:target="search"
                        class="h-2 w-5 text-gray-500 dark:text-gray-400 pl-2"
                    />
                    <div class="w-4"></div>
                </div>
                <div class="flex-1 space-x-2 pr-2">
                    <span class="text-lg">{{ $invoice->title }}</span>
                    <span class="text-sm text-gray-500">({{ number_format($invoice->amount) }}IQD)</span>
                </div>
            </a>
        @endforeach
    @endif
</div>