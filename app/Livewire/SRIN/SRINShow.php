<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use Livewire\Attributes\Locked;
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
    $despatched_note, $received_note, $storeID, $location, $stockCodeID, $issuedStoreID;

    public $items, $reference;

    //FA Approval
    public function faApproval()
    {
        // Validation
        // $this->validate();
    
        if($this->srinID){
            FAAprroval::create([
                'reference'         => $this->reference,
                'fa_approved_note'    => $this->fa_approved_note,
                'fa_approved_action'  => $this->fa_approved_action,
                'fa_approved_by'      => auth()->user()->id,
                'fa_approved_date'    => now()
            ]);
        }

        $this->dispatch('success', message: 'FA Approval!');
        
    }

    //Despatched
    public function despatched()
    {
        $issuedStore = IssuingStore::where('reference', $this->reference)
            ->where('station_id', $this->storeID)->get();
        // dd($issuedStore);

        $binCard = StoreBinCard::where('station_id', $this->issuingStore)
            ->whereIn('stock_code_id', $this->stockCodeID)
            ->where('balance', '>', 0)
            ->orderBy('created_at')
            ->get();

        if (!empty($binCard)) {
            foreach ($issuedStore as $issuedStores) {
                foreach ($binCard as $value) {
                    if ($value->stock_code_id == $issuedStores->stock_code_id) {
                        StoreBinCard::where('id', $value->id)->update([
                            'out'        => $value->out + $issuedStores->quantity,
                            'balance'    => $value->balance - $issuedStores->quantity,
                            'updated_by' => auth()->user()->id,
                        ]);
                    }
                }

                IssuingStore::where('id', $issuedStores->id)->update([
                    'date'      => now(),
                    'issued_by' => auth()->user()->id,
                ]);
            }

            // Despatched
            Despatched::create([
                'reference'          => $this->reference,
                'despatched_note'    => $this->despatched_note,
                'despatched_by'      => auth()->user()->id,
                'despatched_date'    => now()
            ]);

            // Vehicle and Drivers Info
            // Vehicle::create([
            //     'reference'         => $this->reference,
            //     'lorry_no'          => $this->lorry_no,
            //     'driver_name'       => $this->driver_name,
            //     'location'          => $this->location,
            //     'created_by'        => auth()->user()->id,
            //     'vehicle_date'      => now()
            // ]);
            
            $this->dispatch('success', message: 'Despatch Successfully!');

        } else {
            $this->dispatch('danger', message: 'Despatch Fails!');
        }
    }

    //Received
    public function received()
    {
        $issuedStore = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->issuingStore)->get();

        // dd($issuedStore);
        if (!empty($issuedStore)) {
            foreach ($issuedStore as $issuedStores) {
                StoreBinCard::create([
                    'stock_code_id' => $issuedStores->stock_code_id,
                    'reference'     => $this->reference,
                    'station_id'    => $this->issuingStore,
                    'out'           => $issuedStores->quantity,
                    'date_receipt'  => now(),
                ]);
            }

            // Recieved By
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
        $this->location = SRIN::where('srin_id', $this->srinID)->pluck('location')->first();
        $this->items = SRIN::where('srin_id', $this->srinID)->get();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->stockCodeID = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)->pluck('stock_code_id');
        $this->issuingStore = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)->pluck('station_id')->first();
        $this->issuedStoreID = IssuingStore::where('reference', $this->reference)
        ->pluck('station_id')->first();
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
        ]);
    }
}
