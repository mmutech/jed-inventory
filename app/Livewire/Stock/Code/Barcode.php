<?php

namespace App\Livewire\Stock\Code;

use App\Models\Item;
use App\Models\StockCode;
use Livewire\Component;
use Illuminate\Http\Request;

class Barcode extends Component
{
    public $barcode;
    public $stock_code, $items;

    public function searchStockCode()
    {
        // Assuming 'barcode' is a unique identifier for StockCodes
        $this->stock_code = StockCode::where('stock_code', $this->barcode)->first();

        if ($this->stock_code) {
            $this->dispatch('success', message: 'Stock Code Found: '. $this->stock_code->name);
        } else {
            $this->dispatch('warning', message: 'Stock Code Not Found!');
        }

        $this->items = Item::where('stock_code', $this->stock_code->id)->get();

        // dd($this->items);

        // Reset barcode input
        $this->barcode = '';
    }

    // public function handleBarcode(Request $request)
    // {
    //     $barcode = $request->input('barcode');
        
    //     // Search for the Stock Code by the scanned barcode
    //     $stock_code = StockCode::where('barcode', $barcode)->first();

    //     if ($stock_code) {
    //         return view('livewire.stock.code.barcode', compact('stock_code'));
    //     } else {
    //         return redirect()->back()->with('error', 'Stock Code not found.');
    //     }
    // }

    public function render()
    {
        return view('livewire.stock.code.barcode');
    }
}
