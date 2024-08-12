<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\StoreBook;
use Livewire\Component;

class CheckOut extends Component
{
    public $barcode, $referenceId, $storeID;
    public $stock_code, $item, $stocks, $quantity_allocated;

    public function searchStockCode()
    {
        // Assuming 'barcode' is a unique identifier for StockCodes
        $this->stock_code = StockCode::where('stock_code', $this->barcode)->first();

        if ($this->stock_code) {
            $this->item = AllocationModel::where('stock_code_id', $this->stock_code->id)
                ->where('reference', $this->referenceId)
                ->where('allocation_store', $this->storeID)
                ->first();

            $this->dispatch('success', message: 'Stock Code Found: '. $this->stock_code->name);
        } else {
            $this->dispatch('warning', message: 'Stock Code Not Found!');
        }

        // dd($this->item);

        // Reset barcode input
        $this->barcode = '';
    }

    public function addReqStock()
    {
        // Add the stock data to the array
        $this->stocks[] = [
            'referenceId' => $this->referenceId,
            'stock_code' => $this->stock_code->stock_code,
            'quantity_allocated' => $this->item->quantity,
        ];

        $storeBook = StoreBook::where('stock_code_id', $this->stock_code->id)
        ->where('station_id', $this->storeID)
        ->orderBy('created_at', 'desc')
        ->first();

        while ($storeBook !== null && $storeBook->qty_out == $storeBook->qty_in) {
            // Skip the current record and fetch the next one
            $storeBook = StoreBook::where('station_id', $this->storeID)
                ->where('stock_code_id', $this->stock_code->id)
                ->where('created_at', '>', $storeBook->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        $valueOut = $storeBook->basic_price * $this->item->quantity;

        // Store to database
        StoreBook::create([
            'purchase_order_id' => $storeBook->purchase_order_id,
            'stock_code_id' => $this->stock_code->id,
            'reference' => $this->referenceId,
            'station_id' => $this->storeID,
            'issue_store' => $this->item->allocation_store,
            'qty_out' => $this->item->quantity,
            'qty_balance' => $storeBook->qty_balance - $this->item->quantity,
            'basic_price' => $storeBook->basic_price,
            'value_out' => $valueOut,
            'value_balance' => $storeBook->value_balance - $valueOut,
            'date' => now(),
            'created_by' => Auth()->user()->id,
        ]);
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
    }

    public function render()
    {
        return view('livewire.request.check-out');
    }
}
