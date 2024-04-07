<div>

    {{-- idk why first render aint work but u cant mess w me boy --}}

    <select wire:model.live="view"  id="viewSelect" style="background-color: #0f172a" class="block w-full bg-gray-800 text-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="viewSelect">
        <option value="1"  >Grid</option>
        <option value="2">Table</option>
    </select>

<div class="mt-2"></div>
    <select wire:model.live="invoice" style="background-color: #0f172a" id="invoiceSelect"  class="block w-full bg-gray-800 text-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="viewSelect">
        <option value="1" >Dine-in</option>
        <option value="2">Dine-out</option>
    </select>

  <div class="h-5"></div>
  {{ $this->table }}
</div>
