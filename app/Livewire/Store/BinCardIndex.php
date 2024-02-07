<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StoreBinCard;
use Illuminate\Support\Facades\DB;

class BinCardIndex extends Component
{
    use WithPagination;

    public $search = '', $binCard;

    public function mount()
    {
    
    }

    public function render()
    {
        return view('livewire.store.bin-card-index')->with([
            'data' => StoreBinCard::select('stock_code_id', DB::raw('COUNT(*) as count'))->latest()
                ->groupBy('stock_code_id')->where(function ($filter){
                        $filter->where('station_id', 'like', '%'.$this->search.'%')
                        ->orWhere('reference', 'like', '%'.$this->search.'%')
                        ->orWhere('stock_code_id', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
