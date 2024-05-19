<div class="flex flex-col lg:flex-row gap-4 mt-10">
    <!-- Table Section -->
    <div class="w-full lg:w-3/8 mt-3">
        {{$this->table}}
    </div>

    <!-- Form Section -->
    <div class="w-full lg:w-1/9 card bg-white mt-3 rounded">

        <form wire:submit.prevent="create">
            <div class="p-4 shadow-md rounded-md">
                <div class="card-body">
                    {{ $this->form }}
                </div>
                <div class="card-footer flex justify-between">
                    <button style="background-color: #635ffd" type="submit" class="btn btn-primary py-2 px-4 rounded text-white hover:bg-blue-600 ">
                        Submit
                    </button>
                </div>
            </div>
        </form>
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
