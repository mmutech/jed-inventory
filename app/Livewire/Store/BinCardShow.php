<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use App\Models\StoreBinCard;
use App\Models\Store;
use App\Models\SRARemark;
use App\Models\StoreBook;

class BinCardShow extends Component
{
    public $title = 'Stores Bin Card';
    public $search = '';

    public $max, $min, $re_order, $storeID, $data, $items;

    #[Locked]
    public $binID;

    public function stockCode()
    {
        $this->storeID = Store::where('store_officer', auth()->user()->id)->value('id');

        if ($this->search) {
            $storeBinCards = StoreBook::whereHas('stockCodeID', function($query) {
                $query->where('stock_code', 'like', '%' . $this->search . '%');
            })->where('station_id', $this->storeID)->get();

            if ($storeBinCards) {
                $this->data = $storeBinCards->first();
                $this->items = $storeBinCards;
                $this->max = $storeBinCards->max('qty_balance');
                $this->min = $storeBinCards->min('qty_balance');
            } else {
                $this->dispatch('warning', message: 'Store Bin Card Not Available!');
            }
            
        }else{
            $this->data = null;
            $this->items = collect(); // or some default value
            $this->max = null;
            $this->min = null;
        }
        // dd($this->max);
    }

    public function render()
    {
        return view('livewire.store.bin-card-show');
    }
}
