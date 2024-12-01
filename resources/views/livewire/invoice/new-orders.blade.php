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

            </div>

            <button
                wire:click="reduceQuantity({{json_encode($order)}})"
                style="color: red"
                class="ml-2 text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </button>
        @endforeach
    </div>
    <div class="flex flex-col lg:flex-row gap-4 mt-10">
        <!-- Table Section -->
        <div class="w-full lg:w-3/8 mt-3">
            {{$this->table}}
        </div>
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
