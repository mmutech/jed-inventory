<?php

namespace App\Livewire\SRCN;

use App\Models\Approvals;
use App\Models\Despatched;
use App\Models\HODApproval;
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

class SRCNShow extends Component
{
    public $title = 'SRCN Details';

    #[Locked]
    public $srcnID;

    public $recommend_action, $recommend_note, $hod_approved_action, $hod_approved_note, $stockCodeID,
    $despatched_note, $received_note, $lorry_no, $driver_name, $location, $storeID, $stockCode, $binCard, $balance;

    public $items, $reference;

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
    public function hodApproval()
    {
        // Validation
        // $this->validate();
    
        if($this->srcnID){
            HODApproval::create([
                'reference'            => $this->reference,
                'hod_approved_note'    => $this->hod_approved_note,
                'hod_approved_action'  => $this->hod_approved_action,
                'hod_approved_by'      => auth()->user()->id,
                'hod_approved_date'    => now()
            ]);
        }

        $this->dispatch('success', message: 'HOD Approval!');
        
    }

    //Despatched
    public function despatched()
    {
        if($this->srcnID){
            SRCN::where('id', $this->srcnID)->update([
                'issuing_store' => $this->storeID,
                'issue_date' => now(),
                'created_by' => auth()->user()->id,
            ]); 

            Despatched::create([
                'reference'          => $this->reference,
                'despatched_note'    => $this->despatched_note,
                'despatched_by'      => auth()->user()->id,
                'despatched_date'    => now()
            ]);

            Vehicle::create([
                'reference'         => $this->reference,
                'lorry_no'          => $this->lorry_no,
                'driver_name'       => $this->driver_name,
                'location'          => $this->location,
                'created_by'        => auth()->user()->id,
                'vehicle_date'      => now()
            ]);

            // Update Store Bin Card
            foreach ($this->items as $item) {
                $binCard = StoreBinCard::where('stock_code_id', $item->stock_code_id)->first();
                if ($binCard) {
                    $binCard->update([
                        'out'          => $binCard->out + $item->issued_qty,
                        'balance'      => $binCard->balance - $item->issued_qty,
                        'date_issue'   => now(),
                        'updated_by'   => auth()->user()->id,
                    ]);
                } 
            }
            
            $this->dispatch('success', message: 'HOD Approval!');
        } 
    }

    //Received
    public function received()
    {
        if($this->srcnID){
            Received::create([
                'reference'        => $this->reference,
                'received_note'    => $this->received_note,
                'received_by'      => auth()->user()->id,
                'received_date'    => now()
            ]);

            // Create Store Bin Card
            $binCardItems = StoreBinCard::where('reference', $this->reference)->get();
            foreach ($this->items as $item) {

                // Check if there's a matching StoreBinCard record
                $checkBinCard = $binCardItems->where('stock_code_id', $item->stock_code_id)->first();
            
                if ($checkBinCard) {
                    // If a matching record exists, update it
                    $checkBinCard->update([
                        'in'         => $checkBinCard->in + $item->issued_qty,
                        'balance'    => $checkBinCard->balance + $item->issued_qty,
                        'date_issue' => now(),
                        'updated_by' => auth()->user()->id,
                    ]);

                } else {
                    // If no matching record exists, create a new one
                    StoreBinCard::create([
                        'stock_code_id' => $item->stock_code_id,
                        'reference'     => $this->reference,
                        'station_id'    => $this->storeID,
                        'in'            => $item->issued_qty,
                        'balance'       => $item->issued_qty,
                        'unit'          => $item->unit,
                        'date_issue'    => now(),
                        'created_by'    => auth()->user()->id,
                    ]);
                }
            }
        }

        $this->dispatch('success', message: 'HOD Approval!');
        
    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        $this->stockCode = SRCNItem::where('srcn_id', $this->srcnID)->get('stock_code_id');
        $this->stockCodeID = SRCNItem::where('srcn_id', $this->srcnID)->pluck('stock_code_id')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->binCard = StoreBinCard::where('stock_code_id', $this->stockCodeID)->get();
        // dd($this->items);
    }
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-show')->with([
            'data' => SRCN::where('srcn_id', $this->srcnID)->first(),
            'approval' => Approvals::where('reference', $this->reference)->first(),
            'hod_approval' => HODApproval::where('reference', $this->reference)->first(),
            'recommend' => Recommendations::where('reference', $this->reference)->first(),
            'despatch' => Despatched::where('reference', $this->reference)->first(),
            'received' => Received::where('reference', $this->reference)->first(),
            'vehicle' => Vehicle::where('reference', $this->reference)->first(),
        ]);
    }
}
