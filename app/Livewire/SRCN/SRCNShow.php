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
use Livewire\Attributes\Rule; 
use Illuminate\Support\Facades\DB;

class SRCNShow extends Component
{
    public $title = 'SRCN Details';

    #[Locked]
    public $srcnID;

    public $recommend_action, $recommend_note, $approved_action, $approved_note, $issuingStore,
    $despatched_note, $received_note, $lorry_no, $driver_name, $location, $storeID, $requisitionStore;

    public $items, $reference, $stockCodeID, $issuedStore, $issuedStoreID;

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

    //Despatched
    public function despatched()
    {
        $binCard = StoreBinCard::where('station_id', $this->issuingStore)
            ->whereIn('stock_code_id', $this->stockCodeID)
            ->where('balance', '>', 0)
            ->orderBy('created_at')
            ->get();

        if (!empty($binCard)) {
            foreach ($this->issuedStore as $issuedStores) {
                foreach ($binCard as $value) {
                    if ($value->stock_code_id == $issuedStores->stock_code_id) {
                        StoreBinCard::where('id', $value->id)->update([
                            'out'        => $value->out + $issuedStores->quantity,
                            'balance'    => $value->balance - $issuedStores->quantity,
                            'updated_by' => auth()->user()->id,
                        ]);
                    }
                }
            }

            IssuingStore::where('id', $issuedStores->id)->update([
                'date'      => now(),
                'issued_by' => auth()->user()->id,
            ]);

            // Despatched
            Despatched::create([
                'reference'          => $this->reference,
                'despatched_note'    => $this->despatched_note,
                'despatched_by'      => auth()->user()->id,
                'despatched_date'    => now()
            ]);

            // Vehicle and Drivers Info
            Vehicle::create([
                'reference'         => $this->reference,
                'lorry_no'          => $this->lorry_no,
                'driver_name'       => $this->driver_name,
                'location'          => $this->location,
                'created_by'        => auth()->user()->id,
                'vehicle_date'      => now()
            ]);

        } else {
            $this->dispatch('danger', message: 'Despatch Fails!');
        }

        $this->dispatch('success', message: 'Despatch Successfully!');
    }

    //Received
    public function received()
    {
        if($this->srcnID){
            // Create Bin Card
            $binCard = StoreBinCard::where('station_id', $this->issuingStore)
                ->whereIn('stock_code_id', $this->stockCodeID)
                ->where('balance', '>', 0)
                ->orderBy('created_at')
                ->get();

            foreach ($this->issuedStore as $issuedStores) {
                foreach ($binCard as $value) {
                    if ($value->stock_code_id == $issuedStores->stock_code_id) {
                        StoreBinCard::create([
                            'stock_code_id' => $issuedStores->stock_code_id,
                            'unit'          => $value->unit,
                            'reference'     => $this->reference,
                            'station_id'    => $this->requisitionStore,
                            'in'            => $issuedStores->quantity,
                            'balance'       => $issuedStores->quantity,
                            'date_receipt'  => now(),
                        ]);
                    }
                }
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
        // $this->issuingStore = SRCN::where('srcn_id', $this->srcnID)->pluck('issuing_store')->first();
        $this->requisitionStore = SRCN::where('srcn_id', $this->srcnID)->pluck('requisitioning_store')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        $this->stockCodeID = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)->pluck('stock_code_id');
        $this->issuingStore = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)->pluck('station_id')->first();
        $this->issuedStore = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)->get();
        // dd($this->issuedStore);
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
            'issuedStore'      => IssuingStore::where('reference', $this->reference)->get(),
        ]);
    }
}
