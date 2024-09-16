<?php

namespace App\Livewire\Request;

use App\Models\AllocationModel;
use App\Models\HODApproval;
use App\Models\RequestItemTable;
use App\Models\StoreBook;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Allocation extends Component
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
            $this->dispatch('danger', message: 'Items Allocation Fails!');
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
            $this->dispatch('danger', message: 'Items Allocation Fails!');
        }
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $referenceId = $this->referenceId;
        $this->title = substr($referenceId, 0, strpos($referenceId, '-'));

        $this->items = RequestItemTable::where('reference', $this->referenceId)->get();
        $this->stockCodeIDs = RequestItemTable::where('reference', $this->referenceId)->pluck('stock_code_id');
        $this->requisitionStore = RequestItemTable::where('reference', $this->referenceId)->pluck('requisition_store')->first();

         // Get the Issue Store
        $subquery = StoreBook::select('stock_code_id', DB::raw('MAX(created_at) as max_created_at'))
         ->whereIn('stock_code_id', $this->stockCodeIDs)
         ->groupBy('station_id', 'stock_code_id');
 
        $this->allocationStores = StoreBook::joinSub($subquery, 'latest_records', function ($join) {
             $join->on('store_books.stock_code_id', '=', 'latest_records.stock_code_id');
             $join->on('store_books.created_at', '=', 'latest_records.max_created_at');
        })
        ->select('store_books.stock_code_id', 'store_books.station_id', 'store_books.qty_balance as total_balance', 'store_books.created_at')
        ->get();

        // if ($this->items->count() > 0) {
        //     foreach ($this->items as $key => $data) {
        //         $this->itemIDs[$key] = $data->id;
        //         $this->stationIDs[$key] = $data->allocation_store;
        //         $this->allocation_qty[$key] = $data->allocation_qty;
        //     }
        // } else {
        //     $this->dispatch('info', message: 'SRCN Items Not Exist!');
        //     return redirect()->to('srcn-show/' . $this->srcnID);
        // }
        // dd($prefix);
    }

    public function render()
    {
        return view('livewire.request.allocation');
    }
}
