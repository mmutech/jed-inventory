<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Models\Despatched;
use App\Models\FAAprroval;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\Received;
use App\Models\SRIN;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\Vehicle;

class SRINShow extends Component
{
    public $title = 'SRIN Details';

    #[Locked]
    public $srinID;

    public $recommend_action, $recommend_note, $fa_approved_action, $fa_approved_note, $issuingStore,
    $despatched_note, $received_note, $storeID, $location, $stockCodeIDs, $requisitionStore, 
    $issuedStoreID, $items, $reference, $createdBy;

    //FA Approval
    public function faApproval()
    {
        if($this->srinID){
            FAAprroval::create([
                'reference'         => $this->reference,
                'fa_approved_note'    => $this->fa_approved_note,
                'fa_approved_action'  => $this->fa_approved_action,
                'fa_approved_by'      => auth()->user()->id,
                'fa_approved_date'    => now()
            ]);

            $this->dispatch('success', message: 'FA Approval!');
        }
        
    }

    //Received
    public function received()
    {
        $issuedStore = IssuingStore::where('reference', $this->reference)
        ->whereIn('stock_code_id', $this->stockCodeIDs)
        ->groupBy('stock_code_id', 'station_id')
        ->select('stock_code_id', 'station_id', DB::raw('sum(quantity) as total_quantity'))
        ->get();

        // dd($issuedStore);
        if (!empty($issuedStore)) {
            foreach ($issuedStore as $issuedStores) {
                StoreBinCard::create([
                    'stock_code_id' => $issuedStores->stock_code_id,
                    'reference'     => $this->reference,
                    'station_id'    => $issuedStores->station_id,
                    'out'           => $issuedStores->total_quantity,
                    'date_receipt'  => now(),
                ]);
            }

            Received::create([
                'reference'        => $this->reference,
                'received_note'    => $this->received_note,
                'received_by'      => auth()->user()->id,
                'received_date'    => now()
            ]);

            $this->dispatch('success', message: 'Item Received Successfully!');
        }
    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        // $this->requisitionStore = SRIN::where('srin_id', $this->srinID)->pluck('requisitioning_store')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->items = SRIN::where('srin_id', $this->srinID)->get();
        $this->issuedStoreID = IssuingStore::where('reference', $this->reference)->pluck('station_id')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 
        $this->createdBy = SRIN::where('srin_id', $this->srinID)->pluck('created_by')->first();
        // dd($this->srinID);
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-show')->with([
            'data'              => SRIN::where('srin_id', $this->srinID)->first(),
            'fa_approval'       => FAAprroval::where('reference', $this->reference)->first(),
            'hod_approval'      => HODApproval::where('reference', $this->reference)->first(),
            'despatched'        => Despatched::where('reference', $this->reference)->first(),
            'received'          => Received::where('reference', $this->reference)->first(),
            'issuingStores'     => IssuingStore::where('reference', $this->reference)->get(),
            'vehicle'           => Vehicle::where('reference', $this->reference)->get(),
        ]);
    }
}
