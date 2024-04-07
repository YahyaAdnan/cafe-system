<div>
  <div class="flex items-center">
      <div class="w-4/12 md:w-auto mb-4 mr-2">
          <select wire:model.live="view" id="viewSelect" style="background-color: #5f606162" class="w-full border px-4 py-2 rounded shadow leading-tight">
              <option value="1">Grid</option>
              <option value="2">Table</option>
          </select>
      </div>
      <div class="w-4/12 md:w-auto mb-4">
          <select wire:model.live="invoice" style="background-color: #5f606162" id="invoiceSelect" class="w-full border px-4 py-2 rounded shadow leading-tight">
              <option value="1">Dine-in</option>
              <option value="2">Dine-out</option>
          </select>
      </div>
  </div>
  <div class="h-5"></div>
  {{ $this->table }}
</div>
