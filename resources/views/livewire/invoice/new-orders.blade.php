<div>
    <form wire:submit="create">
        <div class="h-8"></div>
        {{ $this->form }}
        <div class="h-8"></div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="py-2 px-4 border border-gray-300 rounded">
                Submit
            </button>
        </div>        
    </form>
</div>
