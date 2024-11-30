<div class="border border-gray-300 rounded-lg shadow-md p-4">
    <div class="flex justify-between">
        <div class="w-1/2 pr-4">
            <h2 class="text-xl font-semibold mb-2">Invoice: {{ $invoice->title }}</h2>
            <p class="mb-4">#{{ $invoice->inovice_no }}</p>
            {{-- <p class="text-sm  mb-2">Table ID: @{{ $table_id }}</p> --}}
            <div style="padding-left: 1rem;">
                <p class="text-md mb-2">Amount: {{ $invoice->amount }} IQD</p>
                @if($invoice->remaining > 0)
                <p class="text-sm mb-2">Remaining: {{ $invoice->remaining }} IQD</p>
                @endif
                @if($invoice->discount_rate > 0)
                    <p class="text-sm mb-2">Discount Rate: {{ $invoice->discount_rate }}%</p>
                @endif
                @if($invoice->discount_fixed > 0)
                    <p class="text-sm mb-2">Discount Fixed: {{ $invoice->discount_fixed }} IQD</p>
                @endif
                <p class="text-sm mb-2">Created Time: {{ $invoice->created_at->format('y/m/d H:i') }}</p>
                @if($invoice->note)
                    <p class="text-sm mb-2">Note: {{ $invoice->note }}</p>
                @endif
                @if($invoice->employee_id)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    <span class="inline-block align-middle">
                        <x-filament::icon
                            icon="heroicon-m-user"
                            wire:target="user"
                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        />
                    </span>
                    {{$invoice->employee->name}}
                </span>
                @endif
                @if($invoice->table_id)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    <span class="inline-block align-middle">
                        <x-filament::icon
                            icon="heroicon-m-archive-box"
                            wire:target="user"
                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        />
                    </span>
                    {{$invoice->table->title}}
                </span>
                @endif
                @if($invoice->deliver_type_id)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    <span class="inline-block align-middle">
                        <x-filament::icon
                            icon="heroicon-m-arrow-left-start-on-rectangle"
                            wire:target="user"
                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        />
                    </span>
                    {{$invoice->deliverType->title}}
                </span>
                @endif
            </div>
        </div>

        <div class="w-1/2 flex justify-end">
            <div class="flex flex-col">
                @if($invoice->active)
                    <a href="/invoices/{{$invoice->id}}/edit" class="inline-block border rounded py-2 px-4 border-2 mb-2">
                        Edit
                    </a>
                    @if($invoice->remaining == 0)
                        <button class="inline-block border rounded py-2 px-4 border-2 b" wire:click="done">
                            Done
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
