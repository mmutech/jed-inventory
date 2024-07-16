<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StoreBinCard;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class BinCardIndex extends Component
{
    use WithPagination;

    public $search = '', $binCard, $storeID;

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
    }

    public function render()
    {
        return view('livewire.store.bin-card-index')->with([
           'data' => StoreBinCard::select('stock_code_id', DB::raw('COUNT(*) as count'), DB::raw('MAX(created_at) as latest_created_at'))
                ->where('station_id', $this->storeID)
                ->groupBy('stock_code_id')
                ->where(function ($filter) {
                    $filter->where('station_id', 'like', '%' . $this->search . '%')
                        ->orWhere('reference', 'like', '%' . $this->search . '%')
                        ->orWhere('stock_code_id', 'like', '%' . $this->search . '%');
                })
                ->orderBy('latest_created_at', 'desc')
                ->paginate(10),
        ]);
    }
}
