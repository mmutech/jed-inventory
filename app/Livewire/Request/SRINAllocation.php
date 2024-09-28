<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\HODApproval;
use App\Models\RequestItemTable;
use App\Models\Store;
use App\Models\StoreBook;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SRINAllocation extends Component
{
    public $title;

    #[Locked]
    public $referenceId;

    public $allocationQty = [], $allocationQuantity;

    public $hod_approved_note, $hod_approved_action, $reference, $items, $stockCodeIDs, 
    $allocationStores, $balance, $requisitionStore;

    #[Rule('required')]
    public $allocation_qty = [], $itemIDs = [], $stationIDs = [], $allocationItems = [], $storeID;

    public function allocationStore($allocation_key, $allocation_store, $stockCodeID)
    {
        if (!empty($allocation_store)) {
            AllocationModel::Create([
                'stock_code_id'         => $stockCodeID,
                'reference'             => $this->referenceId,
                'allocation_store'      => $allocation_store,
                'requisition_store'     => $this->requisitionStore,
                'quantity'              => $this->allocationQty[$allocation_key],
                'date'                  => now(),
                'allocated_by'          => auth()->user()->id,
            ]);

            $this->dispatch('success', message: 'Item Allocated Successfully!');
        } else{
            $this->dispatch('error', message: 'Items Allocation Fails!');
        }
     
    }

    public function update()
    {
        // Issue Quantity
        $allocationQuantity = AllocationModel::where('reference', $this->referenceId)
        ->whereIn('stock_code_id', $this->stockCodeIDs)
        ->groupBy('stock_code_id')
        ->select('stock_code_id', DB::raw('sum(quantity) as total_quantity'))
        ->get();


        $stockCodeId = RequestItemTable::where('reference', $this->referenceId)
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->get();

        if (!empty($allocationQuantity)) {
            foreach ($allocationQuantity as $allocation_qtys) {
                foreach($stockCodeId as $value){
                    // dd($value->stock_code_id);
                    if ($value->stock_code_id == $allocation_qtys->stock_code_id) {
                        RequestItemTable::where('id', $value->id)->update([
                            'quantity_issued' => $allocation_qtys->total_quantity,
                        ]);
                    }
                }
            }

            // HOD Approval and allocation by
            HODApproval::create([
                'reference'            => $this->referenceId,
                'hod_approved_note'    => $this->hod_approved_note,
                'hod_approved_action'  => $this->hod_approved_action,
                'hod_approved_by'      => auth()->user()->id,
                'hod_approved_date'    => now()
            ]);

            if ($this->hod_approved_action == 'Approved') {
                RequestItemTable::where('reference', $this->referenceId)->update([
                    'status' => 'Allocated',
                ]);
            } 

            $this->dispatch('success', message: 'Items Allocated Successfully!');
            return redirect()->to('request-view/' . $this->referenceId);

        }else{
            $this->dispatch('error', message: 'Items Allocation Fails!');
        }
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $referenceId = $this->referenceId;
        $this->title = substr($referenceId, 0, strpos($referenceId, '-'));

        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('store_id')->first();
        $items = RequestItemTable::where('reference', $this->referenceId)->get();

        $this->stockCodeIDs = $items->pluck('stock_code_id');
        $this->requisitionStore = $items->pluck('requisition_store')->first();

         // Get the Issue Store
         $this->allocationStores = RequestItemTable::select(
            'store_books.qty_balance', 
            'request_item_tables.stock_code_id', 
            'request_item_tables.quantity_recommend', 
            'store_books.station_id',
            'store_books.created_at'
        )
        ->join('store_books', 'store_books.stock_code_id', '=', 'request_item_tables.stock_code_id')
        ->whereIn('store_books.stock_code_id', $this->stockCodeIDs)
        ->where('store_books.station_id', $this->storeID)
        ->where('request_item_tables.reference', $this->referenceId)
        ->whereIn(DB::raw("(store_books.stock_code_id, store_books.created_at)"), function($query) {
            $query->select(
                'stock_code_id', 
                DB::raw('MAX(created_at)')
            )
            ->from('store_books')
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->where('station_id', $this->storeID)
            ->groupBy('stock_code_id');
        })
        ->get();
    
    

        //  dd($this->allocationStores);
    }

    public function render()
    {
        return view('livewire.request.s-r-i-n-allocation');
    }
}
