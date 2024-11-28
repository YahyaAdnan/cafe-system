<div class="gap-4 mt-3">
    @foreach ($data['orders'] as $order)
    <span class="inline-block text-sm font-semibold px-3 py-1 rounded-full shadow mt-1 mb-1" style="background-color: {{App\Models\Setting::get("color") ?? "#3b82f6"}};">
        {{$order['title']}} x {{$order['quantity']}}
    </span>
    @endforeach


    <div class="flex flex-col lg:flex-row gap-4 mt-10">
        <!-- Table Section -->
        <div class="w-full mt-3">
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
