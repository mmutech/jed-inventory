<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\Item;
use App\Models\Received;
use App\Models\RequestItemTable;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\StoreBook;
use App\Models\Vehicle;
use Livewire\Component;

class CheckIn extends Component
{
    public $stockCodeID, $referenceId, $storeID, $receive_note, $title;
    public $stock_code, $item, $stocks, $quantity_allocated, $items, $key;

    public function receiveItem($stockCodeID)
    {
        $storeBook = StoreBook::where('stock_code_id', $stockCodeID)
        ->where('station_id', $this->storeID)
        ->orderBy('created_at', 'desc')
        ->first();

        while ($storeBook !== null && $storeBook->qty_out == $storeBook->qty_in) {
            // Skip the current record and fetch the next one
            $storeBook = StoreBook::where('station_id', $this->storeID)
                ->where('stock_code_id', $stockCodeID)
                ->where('created_at', '>', $storeBook->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $item = RequestItemTable::where('reference', $this->referenceId)
        ->where('stock_code_id', $stockCodeID)
        ->where('requisition_store', $this->storeID)->first();

        if ($item->status == 'Issued') {
            if ($storeBook) {
                $valueIn = $storeBook->basic_price * $item->quantity_issued;
    
                // Store to database
                StoreBook::create([
                    'purchase_order_id' => $storeBook->purchase_order_id,
                    'stock_code_id' => $stockCodeID,
                    'reference' => $this->referenceId,
                    'station_id' => $item->requisition_store,
                    'qty_in' => $item->quantity_issued,
                    'qty_balance' => $storeBook->qty_balance + $item->quantity_issued,
                    'basic_price' => $storeBook->basic_price,
                    'value_in' => $valueIn,
                    'value_balance' => $storeBook->value_balance + $valueIn,
                    'date' => now(),
                    'created_by' => Auth()->user()->id,
                ]);
    
                // Update Request Status
                RequestItemTable::where('reference', $this->referenceId)->update([
                    'status' => 'Received',
                    'receive_date' => now(),
                ]);
    
                // Update Delivery Status
                Vehicle::where('reference', $this->referenceId)->update([
                    'status' => 'Delivered',
                    'delivery_date' => now(),
                ]);
    
                $this->dispatch('success', message: 'Item Received');
    
            } else {
                // If no matching StoreBook found, check as IDa fallback
                $allocationStoreID = AllocationModel::where('stock_code_id', $stockCodeID)
                    ->where('reference', $this->referenceId)
                    ->pluck('allocation_store')
                    ->first();

                $allocation_store = StoreBook::where('stock_code_id', $stockCodeID)
                    ->where('station_id', $allocationStoreID )
                    ->orderBy('created_at', 'desc')
                    ->first();
    
                $valueIn = $allocation_store->basic_price * $item->quantity_issued;
    
                // Store to database
                StoreBook::create([
                    'purchase_order_id' => $allocation_store->purchase_order_id,
                    'stock_code_id' => $stockCodeID,
                    'reference' => $this->referenceId,
                    'station_id' => $item->requisition_store,
                    'qty_in' => $item->quantity_issued,
                    'qty_balance' => $item->quantity_issued,
                    'basic_price' => $allocation_store->basic_price,
                    'value_in' => $valueIn,
                    'value_balance' => $valueIn,
                    'date' => now(),
                    'created_by' => Auth()->user()->id,
                ]);
    
                // Update Request Status
                RequestItemTable::where('reference', $this->referenceId)->update([
                    'status' => 'Received',
                    'receive_date' => now(),
                ]);
    
                // Update Delivery Status
                Vehicle::where('reference', $this->referenceId)->update([
                    'status' => 'Delivered',
                    'delivery_date' => now(),
                ]);
    
                $this->dispatch('success', message: 'Item Received');
            }
        }else {
            $this->dispatch('error', message: 'Item Already Received!');
        }

        $this->stockCodeID = '';
       
    }

    public function srinReceive($id)
    {
        if (!RequestItemTable::where('id', $id)->pluck('status')->first() == 'Received') {
            RequestItemTable::where('id', $id)->update([
                'status' => 'Received',
                'receive_date' => now(),
            ]);

            $this->dispatch('success', message: 'Item Received!');
        }else {
            $this->dispatch('error', message: 'Item Receive Fail!');
        }
       
    }

    public function received()
    {
        if (!Received::where('reference', $this->referenceId)->exists()) {
            Received::create([
                'received_note' => $this->receive_note,
                'reference' => $this->referenceId,
                'received_date' => now(),
                'received_by' => Auth()->user()->id,
            ]);

            $this->dispatch('success', message: 'Received Note Added!');
            return redirect()->to('request-view/' . $this->referenceId);
        }else {
            $this->dispatch('error', message: 'Received Note Fail!');
        }
       
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $this->title = substr($referenceId, 0, strpos($referenceId, '-'));
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->items = RequestItemTable::where('reference', $this->referenceId)->get();

        // dd($this->items);
    }

    public function render()
    {
        return view('livewire.request.check-in');
    }
}
