<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\RequestItemTable;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\StoreBook;
use App\Models\Vehicle;
use Livewire\Component;

class CheckOut extends Component
{
    public $barcode, $referenceId, $storeID, $station;
    public $stock_code, $item, $stocks, $quantity_allocated;
    public $lorry_no, $driver_name;

    public function searchStockCode()
    {
        // Assuming 'barcode' is a unique identifier for StockCodes
        $this->stock_code = StockCode::where('stock_code', $this->barcode)->first();

        if ($this->stock_code) {
            // Check if there is any record with the same reference, stock code, and quantity_issued not null
            // $requestItem = RequestItemTable::where('reference', $this->referenceId)
            //     ->where('stock_code_id', $this->stock_code->id)
            //     ->whereNotNull('quantity_issued')
            //     ->exists();
        
            // if (!$requestItem) {
                // If no record exists with a non-null quantity_issued, fetch the allocation model
                $this->item = AllocationModel::where('stock_code_id', $this->stock_code->id)
                    ->where('reference', $this->referenceId)
                    ->where('allocation_store', $this->storeID)
                    ->first();
        
                // Dispatch success message
                $this->dispatch('success', message: 'Stock Code Found: ' . $this->stock_code->name);
            // } else {
            //     $this->dispatch('warning', message: 'This Item has been Issued');
            // }
        } else {
            // Dispatch warning message if stock code is not set
            $this->dispatch('warning', message: 'Stock Code Not Found!');
        }

        // Reset barcode input
        $this->barcode = '';
    }

    public function addReqStock()
    {
        $this->item = AllocationModel::where('stock_code_id', $this->stock_code->id)
            ->where('reference', $this->referenceId)
            ->where('allocation_store', $this->storeID)
            ->first();

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

        // Update Request Status
        RequestItemTable::where('reference', $this->referenceId)->update([
            'status' => 'Issued',
        ]);

        $this->dispatch('success', message: 'Item Issued');
    }

    public function addLorryDetails()
    {
        Vehicle::create([
            'lorry_no' => $this->lorry_no,
            'driver_name' => $this->driver_name,
            'reference' => $this->referenceId,
            'pickup_station' => $this->item->allocation_store,
            'delivery_station' => $this->item->requisition_store,
            'status' => 'Picked Up',
            'pickup_date' => now(),
            'created_by' => Auth()->user()->id,
        ]);
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // dd($this->storeID);
    }

    public function render()
    {
        return view('livewire.request.check-out');
    }
}
