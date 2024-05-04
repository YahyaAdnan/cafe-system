<div>
    <div class="flex items-center gap-2">
        <div class="w-4/12 md:w-auto mb-4 mr-2">
            <button class="inline-block border rounded py-2 px-4 border-2" wire:click.live="$toggle('tableView')">
                Change View
            </button>

            <button class="inline-block border rounded py-2 px-4 border-2" wire:click.live="$toggle('dinein')">
                Dine-in/Dine-out
            </button>
        </div>
    </div>

    <div wire:key="view-{{$tableView}}-{{$dinein}}">
        {{ $this->table }}
    </div>
</div>
