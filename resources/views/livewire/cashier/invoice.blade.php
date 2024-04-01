<div>
    {{-- Be like water. --}}
    <ul class="flex justify-between">
        @foreach ($navigators as $key => $navigator)
        <li class="mr-3">
            <button class="inline-block border rounded py-2 px-4 
                @if ($selected_nav == $key) border-2 font-bold @endif" 
                wire:click="$set('selected_nav', {{$key}})">
                {{$navigator}}
            </button>
          </li>
        @endforeach
    </ul>
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
</div>
