<?php

namespace App\Livewire\Reports;

use App\Models\StockCode;
use App\Models\StoreBook;
use Livewire\Component;

class SingleBinCard extends Component
{
    public $binCardID, $stockMovements, $stock, $max, $min, $reorder;

    public function mount($binCardID)
    {
        $this->binCardID = $binCardID;

        $this->stock = StockCode::where('id', $this->binCardID)->first();

        // Aggregate
        $this->max = StoreBook::where('stock_code_id', $this->binCardID)->max('qty_balance');
        $this->min = StoreBook::where('stock_code_id', $this->binCardID)->max('qty_balance');
        $this->reorder = 10 * 14;
        // Stock Movement
        $query = StoreBook::where('stock_code_id', $this->binCardID);

        if (auth()->user()->hasRole('Store-Officer')) {
            $query->where('station_id', $this->storeID);
        }

        $this->stockMovements = $query->get();

        // dd($this->max);

    }

    public function render()
    {
        return view('livewire.reports.single-bin-card');
    }
}
