<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\StoreLedger;
use App\Models\Store;
use Livewire\Attributes\Locked;

class StoreLedgerShow extends Component
{
    public $title = 'Stores Ledger', $storeID;

    #[Locked]
    public $ledgerID;

    public function mount($ledgerID)
    {
        $this->ledgerID = $ledgerID;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // dd($this->ledgerID);
    }

    public function render()
    {
        return view('livewire.store.store-ledger-show')->with([
            'data' => StoreLedger::where('stock_code_id', $this->ledgerID)->where('station_id', $this->storeID)->first(),
            'items' => StoreLedger::where('stock_code_id', $this->ledgerID)->where('station_id', $this->storeID)->get(),
        ]);
    }
}
