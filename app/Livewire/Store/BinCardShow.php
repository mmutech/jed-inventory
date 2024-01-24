<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use App\Models\StoreBinCard;
use App\Models\SRARemark;


class BinCardShow extends Component
{
    public $title = 'Stores Bin Card';

    public $max, $min, $re_order;

    #[Locked]
    public $binID;

    public function mount($binID)
    {
        $this->binID = $binID;

        $this->max = StoreBinCard::where('stock_code_id', $binID)->max('balance');
        $this->min = StoreBinCard::where('stock_code_id', $binID)->min('balance');
        // dd($this->max);
    }

    public function render()
    {
        return view('livewire.store.bin-card-show')->with([
            'data' => StoreBinCard::where('stock_code_id', $this->binID)->first(),
            'items' => StoreBinCard::where('stock_code_id', $this->binID)->get(),
        ]);
    }
}
