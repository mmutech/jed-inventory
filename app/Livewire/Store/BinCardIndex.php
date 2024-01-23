<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StoreBinCard;

class BinCardIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.store.bin-card-index')->with([
            'data' => StoreBinCard::latest()
            ->where(function ($filter){
                    $filter->where('station_id', 'like', '%'.$this->search.'%')
                        ->orWhere('reference', 'like', '%'.$this->search.'%')
                        ->orWhere('stock_code_id', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
