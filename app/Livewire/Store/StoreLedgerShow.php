<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\StoreLedger;
use App\Models\Store;
use App\Models\StoreBook;
use Livewire\Attributes\Locked;

class StoreLedgerShow extends Component
{
    public $title = 'Stores Ledger', $storeID, $data, $items, $search;

    public function stockCode()
    {
        $this->storeID = Store::where('store_officer', auth()->user()->id)->value('id');

        if ($this->search) {
            $storeLedger = StoreBook::whereHas('stockCodeID', function($query) {
                $query->where('stock_code', 'like', '%' . $this->search . '%');
            })->where('station_id', $this->storeID)->get();

            if ($storeLedger) {
                $this->data = $storeLedger->first();
                $this->items = $storeLedger;
            } else {
                $this->dispatch('warning', message: 'Store Bin Card Not Available!');
            }
            
        }else{
            $this->data = null;
            $this->items = collect(); // or some default value
        }
        // dd($this->max);
    }

    public function render()
    {
        return view('livewire.store.store-ledger-show');
    }
}
