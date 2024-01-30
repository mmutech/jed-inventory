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

    public $recommend_action, $recommend_note, $approved_action, $approved_note, $issuingStore,
    $despatched_note, $received_note, $lorry_no, $driver_name, $location, $storeID, $requisitionStore;

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
         // Check Store Bin Card
        foreach ($this->items as $item) {
            $binCard = StoreBinCard::where('stock_code_id', $item->stock_code_id)
                    ->where('station_id', $this->issuingStore)
                    ->where('balance', '>', 0)
                    ->orderBy('created_at')
                    ->first();

            if(!empty($binCard)){
                $issuedQty = min($item->issued_qty, $binCard->balance);

                // Update the oldest record
                $binCard->update([
                    'out'          => $binCard->out + $issuedQty,
                    'balance'      => $binCard->balance - $issuedQty,
                    'date_issue'   => now(),
                    'updated_by'   => auth()->user()->id,
                ]);

                $remainingQty = $item->issued_qty - $issuedQty;
                while ($remainingQty > 0) {
                    $nextBinCard = StoreBinCard::where('stock_code_id', $item->stock_code_id)
                        ->where('station_id', $this->issuingStore)
                        ->where('balance', '>', 0)
                        ->where('created_at', '>', $binCard->created_at)
                        ->orderBy('created_at')
                        ->first();
        
                    if ($nextBinCard) {
                        $issuedQty = min($remainingQty, $nextBinCard->balance);
        
                        // Update the next record
                        $nextBinCard->update([
                            'out' => $nextBinCard->out + $issuedQty,
                            'balance' => $nextBinCard->balance - $issuedQty,
                            'date_issue' => now(),
                            'updated_by' => auth()->user()->id,
                        ]);
        
                        $remainingQty -= $issuedQty;
                    } else {

                        break;
                    }
                }

            }
        }

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

        // Update SRCN 
        SRCN::where('srcn_id', $this->srcnID)->first()->update([
            'issue_date' => now(),
        ]); 

        $this->dispatch('success', message: 'Despatch Successfully!');
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

            // Create or Update Store Bin Card
            $binCardItems = StoreBinCard::where('reference', $this->reference)->get();
            foreach ($this->items as $item) {

                // Check if there's a matching StoreBinCard record
                // $checkBinCard = $binCardItems->where('stock_code_id', $item->stock_code_id)->first();
            
                // if ($checkBinCard) {
                //     // If a matching record exists, update it
                //     $checkBinCard->update([
                //         'in'         => $checkBinCard->in + $item->issued_qty,
                //         'balance'    => $checkBinCard->balance + $item->issued_qty,
                //         'date_issue' => now(),
                //         'date_receipt'  => now(),
                //         'updated_by' => auth()->user()->id,
                //     ]);

                // } else {
                    // If no matching record exists, create a new one
                    StoreBinCard::create([
                        'stock_code_id' => $item->stock_code_id,
                        'reference'     => $this->reference,
                        'station_id'    => $this->requisitionStore,
                        'in'            => $item->issued_qty,
                        'balance'       => $item->issued_qty,
                        'unit'          => $item->unit,
                        'date_receipt'  => now(),
                        'created_by'    => auth()->user()->id,
                    ]);
                // }
            }

            $this->dispatch('success', message: 'Item Received Successfully!');
        }
    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->issuingStore = SRCN::where('srcn_id', $this->srcnID)->pluck('issuing_store')->first();
        $this->requisitionStore = SRCN::where('srcn_id', $this->srcnID)->pluck('requisitioning_store')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        // dd($this->issuingStore);
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
