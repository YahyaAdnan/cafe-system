<div class="gap-4 mt-3">
    <div class="flex flex-wrap gap-3 p-4">
        @foreach ($data['orders'] as $order)
            <div class="group inline-flex items-center gap-3 px-4 py-2 rounded-xl shadow-sm transition-all duration-200 hover:shadow-md"
                 style="background-color: white">

                <span class="text-gray-600">
                    {{$order['title']}}
                    <span class="inline-flex items-center justify-center px-2 py-0.5 ml-2 text-xs font-medium bg-white/20 rounded-full">
                    X {{$order['quantity']}}
                    </span>
                </span>

                <button
                    wire:click="reduceQuantity({{json_encode($order)}})"
                    style="color: red"
                    class="ml-2 text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                        @if($order['quantity'] > 1)
                            {{-- TODO: if it's more than 1 make it minus in a cricle (THE ICON) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        @endif
                </button>
                  
            </div>
        @endforeach
    </div>

    <div class="flex flex-wrap p-4 border-t gap-2">
        @foreach($itemTypes as $type)
            <div class="group inline-flex items-center gap-1 px-1 py-2">
                <x-filament::button
                    type="submit"
                    size="md"
                    color="{{$type->id == $filter['item_type_id'] ? 'primary' : 'gray'}}"
                    wire:click="updateItemTypeId({{ $type->id }})"
                >
                    {{ $type->title }}
                </x-filament::button>
            </div>
        @endforeach
    </div>
    

    <div class="flex flex-1 mt-4">                
        <div class="w-1/4 p-4 border-r">
            <h3 class="text-lg font-bold mb-4">Categories</h3>
        
            @foreach($categories as $category)
                <div class="mb-2">
                    <x-filament::button
                        type="submit"
                        size="sm"
                        color="{{$category->id == $filter['item_category_id'] ? 'primary' : 'gray'}}"
                        class="w-full"
                        wire:click="updateItemCategoryId({{ $category->id }})"
                    >
                        {{ $category->title }}
                    </x-filament::button>
                </div>
            @endforeach
        </div>
        
        

        <!-- Items Grid occupies the remaining space -->
        <div class="flex-1 p-4">
            {{$this->table}}
        </div>

</div>
@assets
<style>
    /* Make entire table row clickable */
    .filament-tables-row {
        cursor: pointer;
    }
    .filament-tables-row:hover {
        background-color: rgb(249 250 251);
    }

    @media (min-width: 1524px) {
        .lg\:w-3\/8 {
            width: 95%;
        }
        .lg\:w-1\/9 {
            width: 40%;
        }
    }
</style>
@endassets
