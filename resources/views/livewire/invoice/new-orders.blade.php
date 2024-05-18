<div class="grid grid-cols-4 mt-4">
    <div class="col-span-2 m-1">
        {{$this->table}}
    </div>
    <div class="col-span-2 m-1">
        <form wire:submit="create">
            {{-- TO-DO: make it card with submit and cancel --}}
            <div class="flex justify-center mt-5">
                <button type="submit" class="py-2 px-4 border border-gray-300 rounded">
                    Submit
                </button>
            </div>
            {{ $this->form }} 
        </form>
    </div>
</div>
