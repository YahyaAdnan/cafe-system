<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-10" style="margin-top: 10px">
    <!-- Table Section -->
    <div class="md:col-span-3 w-full">
        {{$this->table}}
    </div>

    <!-- Form Section -->
    <div class="md:col-span-1 w-full">
        <form wire:submit.prevent="create">
            <div class="card bg-white p-4 shadow-md rounded-md">
                <div class="card-body">
                    {{ $this->form }}
                </div>
                <div class="card-footer flex justify-between">
                    <button style="background-color: #635ffd" type="submit" class="btn btn-primary py-2 px-4 rounded text-white hover:bg-blue-600">
                        Submit
                    </button>
                    <button type="button" class="btn btn-secondary py-2 px-4 rounded bg-gray-500 text-white hover:bg-gray-600" wire:click="cancel">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
