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

                <x-filament::icon-button type="button"
                        style="color: red"
                        icon="heroicon-o-trash"
                    />
            </div>
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
