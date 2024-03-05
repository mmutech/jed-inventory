<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 

use App\Models\SRIN;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\StockCode;
use App\Models\StoreBinCard;
use Illuminate\Support\Facades\DB;

class SRINAllocation extends Component
{
    public $title = 'SRIN Allocation';

    #[Locked]
    public $srinID;

    public $allocationQty = [], $allocationQuantity;

    public $hod_approved_note, $hod_approved_action, $reference, $items, $stockCodeIDs, $allocationStores;


    public function allocationStore($allocation_key, $station_id, $stockCodeID)
    {
        if (!empty($station_id)) {
            IssuingStore::Create([
                'stock_code_id' => $stockCodeID,
                'reference'     => $this->reference,
                'station_id'    => $station_id,
                'quantity'      => $this->allocationQty[$allocation_key],
                'date'          => now()
            ]);

        } 
     
    }

    public function update()
    {
        // Issue Quantity
        $allocationQuantity = IssuingStore::where('reference', $this->reference)
        ->whereIn('stock_code_id', $this->stockCodeIDs)
        ->groupBy('stock_code_id')
        ->select('stock_code_id', DB::raw('sum(quantity) as total_quantity'))
        ->get();

        $srin = SRIN::where('srin_id', $this->srinID)
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->get();


        if (!empty($allocationQuantity)) {
            foreach ($allocationQuantity as $allocation_qtys) {
                foreach($srin as $value){
                    // dd($value->stock_code_id);
                    if ($value->stock_code_id == $allocation_qtys->stock_code_id) {
                        SRIN::where('id', $value->id)->update([
                            'issued_qty' => $allocation_qtys->total_quantity,
                        ]);
                    }
                }
            }

            // HOD Approval and allocation by
            HODApproval::create([
                'reference'            => $this->reference,
                'hod_approved_note'    => $this->hod_approved_note,
                'hod_approved_action'  => $this->hod_approved_action,
                'hod_approved_by'      => auth()->user()->id,
                'hod_approved_date'    => now()
            ]);

            $this->dispatch('success', message: 'Item allocation Successfully!');
            return redirect()->to('srin-show/' . $this->srinID);

        }else{
            $this->dispatch('danger', message: 'Item allocation Not Found!');
        }
    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 

        // Get the Issue Store
        $subquery = StoreBinCard::select('stock_code_id', DB::raw('MAX(created_at) as max_created_at'))
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->groupBy('station_id', 'stock_code_id');
    
        $this->allocationStores = StoreBinCard::joinSub($subquery, 'latest_records', function ($join) {
                $join->on('store_bin_cards.stock_code_id', '=', 'latest_records.stock_code_id');
                $join->on('store_bin_cards.created_at', '=', 'latest_records.max_created_at');
            })
            ->select('store_bin_cards.stock_code_id', 'store_bin_cards.station_id', 'store_bin_cards.balance as total_balance', 'store_bin_cards.created_at')
            ->get();

 
        // Get the SRiN Item
        $this->items = SRIN::where('srin_id', $this->srinID)->get();

        // dd($this->allocationStore);
       
        // if ($this->items->count() > 0) {
        //     foreach ($this->items as $key => $data) {
        //         $this->itemIDs[$key] = $data->id;
        //         $this->stationIDs[$key] = $data->station_id;
        //         $this->allocation_qty[$key] = $data->allocation_qty;
        //     }
        // } else {
        //     $this->dispatch('info', message: 'SRiN Items Not Exist!');
        //     return redirect()->to('srin-show/' . $this->srinID);
        // }
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-allocation')->with([
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
