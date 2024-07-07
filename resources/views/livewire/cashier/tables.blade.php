<div>
    <div class="flex items-center gap-2">
        <div class="w-4/12 md:w-auto mb-4 mr-2">
            <button class="inline-block border rounded py-2 px-4 border-2" wire:click="$set('tableView', '{{ $tableView === '1' ? '0' : '1' }}')">
                {{ $tableView === '1' ? 'Switch to Grid' : 'Switch to Table' }}
            </button>

            <button class="inline-block border rounded py-2 px-4 border-2" wire:click="$set('dinein', '{{ $dinein === '1' ? '0' : '1' }}')">
                {{ $dinein === '1' ? 'Switch to Dine-out' : 'Switch to Dine-in' }}
            </button>
        </div>
    </div>

    <div wire:key="table-{{ $renderKey }}">
        {{ $this->table }}
    </div>
</div>
