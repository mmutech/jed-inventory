<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\Approvals;
use App\Models\Despatched;
use App\Models\HODApproval;
use App\Models\Received;
use App\Models\Recommendations;
use App\Models\RequestItemTable;
use App\Models\SCNRequestTable;
use App\Models\Store;
use App\Models\StoreBook;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestView extends Component
{
    public $title;

    #[Locked]
    public $referenceId;

    public $approved_action, $approved_note,
    $storeID, $data, $createdBy, $allocation, $scn;

    public $items, $reference, $stockCodeID, $issuingStore, $issuedStore, $issuedStoreID;

 
    //HOD Approval
    public function haopApproval()
    {
        if($this->referenceId){
            Approvals::create([
                'reference'         => $this->referenceId,
                'approved_note'    => $this->approved_note,
                'approved_action'  => $this->approved_action,
                'approved_by'      => auth()->user()->id,
                'approved_date'    => now()
            ]);

            if ($this->approved_action == 'Approved') {
                RequestItemTable::where('reference', $this->referenceId)->update([
                    'status' => 'Approved',
                ]);
            } 

            $this->dispatch('success', message: 'HAOP Approval!');
        }
        
    }

    public function scnReceive($stockCodeID, $referenceId)
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

        $item = SCNRequestTable::where('reference', $referenceId)
        ->where('stock_code_id', $stockCodeID)
        ->first();

        // dd($item->quantity_returned);

        if ($item) {
                $valueIn = $storeBook->basic_price * $item->quantity_returned;
    
                // Store to database
                StoreBook::create([
                    'purchase_order_id' => $storeBook->purchase_order_id,
                    'stock_code_id' => $stockCodeID,
                    'reference' => $referenceId,
                    'station_id' => $this->storeID ,
                    'qty_in' => $item->quantity_returned,
                    'qty_balance' => $storeBook->qty_balance + $item->quantity_returned,
                    'basic_price' => $storeBook->basic_price,
                    'value_in' => $valueIn,
                    'value_balance' => $storeBook->value_balance + $valueIn,
                    'date' => now(),
                    'created_by' => Auth()->user()->id,
                ]);
    
                // Update Request Status
                RequestItemTable::where('reference', $referenceId)
                ->where('stock_code_id', $stockCodeID)
                ->update([
                    'status' => 'Received',
                    'receive_date' => now(),
                ]);
    
                // Update Delivery Status
                Vehicle::where('reference', $referenceId)->update([
                    'status' => 'Delivered',
                    'delivery_date' => now(),
                ]);
    
                $this->dispatch('success', message: 'Item Received');

        }else {
            $this->dispatch('error', message: 'Item Already Received!');
        }

        $this->stockCodeID = '';
       
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $referenceId = $this->referenceId;
        $this->title = substr($referenceId, 0, strpos($referenceId, '-'));

        $this->data = RequestItemTable::where('reference', $this->referenceId)->first();
        $this->items = RequestItemTable::where('reference', $this->referenceId)->get();
        $this->allocation = AllocationModel::where('reference', $this->referenceId)->get();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('store_id')->first();

        $this->scn = SCNRequestTable::where('srin_id', $this->referenceId)->get();
        // dd($this->scn);
    }

    public function render()
    {
        return view('livewire.request.request-view')->with([
            'vehicle'          => Vehicle::where('reference', $this->referenceId)->get(),
            'approval'         => Approvals::where('reference', $this->referenceId)->first(),
            'hod_approval'     => HODApproval::where('reference', $this->referenceId)->first(),
            'recommend'        => Recommendations::where('reference', $this->referenceId)->first(),
            'despatch'         => Despatched::where('reference', $this->referenceId)->first(),
            'received'         => Received::where('reference', $this->referenceId)->first(),
            'check_out'        => AllocationModel::where('reference', $this->referenceId)->pluck('allocation_store')->first(),
            'check_in'         => AllocationModel::where('reference', $this->referenceId)->pluck('requisition_store')->first(),
        ]);
    }
}
