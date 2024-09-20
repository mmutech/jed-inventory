<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Store;
use App\Models\StoreBook;
use Illuminate\Support\Facades\DB;

class BinCardIndex extends Component
{
    use WithPagination;

    public $search = '', $binCard, $storeID, $data, $qty_in, $qty_out, $value_in, $value_out;

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->data = StoreBook::select('store_books.stock_code_id', 'stock_codes.stock_code as stock_code', 
            DB::raw('SUM(qty_in) as qty_in'),
            DB::raw('SUM(qty_out) as qty_out'),
            DB::raw('SUM(store_books.value_in) as value_in'), 
            DB::raw('SUM(store_books.value_out) as value_out'))
            ->join('stock_codes', 'store_books.stock_code_id', '=', 'stock_codes.id')
            ->where('store_books.station_id', $this->storeID)
            ->where('stock_codes.stock_code', 'like', '%' . $this->search . '%')
            ->groupBy('stock_codes.stock_code', 'store_books.stock_code_id')
            ->get();

        $this->qty_in = StoreBook::where('station_id', $this->storeID)->sum('qty_in');
        $this->qty_out = StoreBook::where('station_id', $this->storeID)->sum('qty_out');
        $this->value_in = StoreBook::where('station_id', $this->storeID)->sum('value_in');
        $this->value_out = StoreBook::where('station_id', $this->storeID)->sum('value_out');
    }

    public function render()
    {
        return view('livewire.store.bin-card-index');
           
    }
}
