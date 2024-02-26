<?php

namespace App\Livewire\SRCN;

use App\Models\Approvals;
use App\Models\Despatched;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\Received;
use App\Models\Recommendations;
use Livewire\Component;
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\Vehicle;
use Livewire\Attributes\Locked;

class SRCNShow extends Component
{
    public $title = 'SRCN Details';

    #[Locked]
    public $srcnID;

    public $recommend_action, $recommend_note, $approved_action, $approved_note,
    $storeID, $requisitionStore, $received_note;

    public $items, $reference, $stockCodeID, $issuingStore, $issuedStore, $issuedStoreID;

    //Recommendation
    public function recommend()
    {
        // Validation
        // $this->validate();
    
        if($this->srcnID){
            Recommendations::create([
                'reference'         => $this->reference,
                'recommend_note'    => $this->recommend_note,
                'recommend_action'  => $this->recommend_action,
                'recommend_by'      => auth()->user()->id,
                'recommend_date'    => now()
            ]);
        }

        $this->dispatch('success', message: 'Recommend!');
        
    }

    //HOD Approval
    public function haopApproval()
    {
        // Validation
        // $this->validate();
    
        if($this->srcnID){
            Approvals::create([
                'reference'         => $this->reference,
                'approved_note'    => $this->approved_note,
                'approved_action'  => $this->approved_action,
                'approved_by'      => auth()->user()->id,
                'approved_date'    => now()
            ]);
        }

        $this->dispatch('success', message: 'HAOP Approval!');
        
    }

    //Received
    public function received()
    {
        $issuedStore = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->issuedStoreID)->get();

        // dd($issuedStore);
        if (!empty($issuedStore)) {
            foreach ($issuedStore as $issuedStores) {
                StoreBinCard::create([
                    'stock_code_id' => $issuedStores->stock_code_id,
                    'reference'     => $this->reference,
                    'station_id'    => $this->requisitionStore,
                    'in'            => $issuedStores->quantity,
                    'balance'       => $issuedStores->quantity,
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

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->requisitionStore = SRCN::where('srcn_id', $this->srcnID)->pluck('requisitioning_store')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        $this->issuedStoreID = IssuingStore::where('reference', $this->reference)
        ->pluck('station_id')->first();

        // dd($this->issuedStoreID);
    }
    
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-show')->with([
            'data'             => SRCN::where('srcn_id', $this->srcnID)->first(),
            'approval'         => Approvals::where('reference', $this->reference)->first(),
            'hod_approval'     => HODApproval::where('reference', $this->reference)->first(),
            'recommend'        => Recommendations::where('reference', $this->reference)->first(),
            'despatch'         => Despatched::where('reference', $this->reference)->first(),
            'received'         => Received::where('reference', $this->reference)->first(),
            'vehicle'          => Vehicle::where('reference', $this->reference)->first(),
        ]);
    }
}
