<div>
    {{-- Be like water. --}}
    @if($record->active)
    <div class="flex w-full pt-4">
        @foreach ($navigators as $key => $navigator)
            <x-filament::button
                size="md"
                color="gray"
                class="flex-1"
                color="{{$selected_nav == $key ? 'primary' : 'gray'}}"
                wire:click="$set('selected_nav', {{ $key }})"
            >
                {{ $navigator }}
            </x-filament::button>
        @endforeach
    </div>
    
        
        @switch($selected_nav)
            @case(1)
                @livewire('invoice.new-orders', ['invoice' => $record])
                @break
            @case(2)
                @livewire('invoice.orders', ['invoice' => $record])
                @break
            @case(3)
                @livewire('invoice.payments', ['invoice' => $record])
                @break
            @default
        @endswitch
    @else
        @livewire('invoice.orders', ['invoice' => $record])
    @endif

</div>
