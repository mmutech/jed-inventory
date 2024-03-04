<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StoreLedger;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class StoreLedgerIndex extends Component
{
    use WithPagination;

    public $search = '', $storeLedger, $storeID;

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // dd($this->ledgerID);
    }

    public function render()
    {
        return view('livewire.store.store-ledger-index')->with([
            'data' => StoreLedger::select('stock_code_id', DB::raw('COUNT(*) as count'))->latest()
                ->where('station_id', $this->storeID)
                ->groupBy('stock_code_id')->where(function ($filter){
                        $filter->where('station_id', 'like', '%'.$this->search.'%')
                        ->orWhere('reference', 'like', '%'.$this->search.'%')
                        ->orWhere('stock_code_id', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
