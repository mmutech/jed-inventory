<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Models\Despatched;
use App\Models\FAAprroval;
use App\Models\HODApproval;
use App\Models\Received;
use App\Models\SRIN;
use App\Models\Store;
use App\Models\StoreBinCard;

class SRINShow extends Component
{
    public $title = 'SRIN Details';

    #[Locked]
    public $srinID;

    public $recommend_action, $recommend_note, $fa_approved_action, $fa_approved_note, $issuingStore,
    $despatched_note, $received_note, $storeID, $requisitionStore;

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
        // Check Store Bin Card and Issue
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

        // Create Store Bin Card
        foreach ($this->items as $item) {
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
        }

        // Despatched
        Despatched::create([
            'reference'          => $this->reference,
            'despatched_note'    => $this->despatched_note,
            'despatched_by'      => auth()->user()->id,
            'despatched_date'    => now()
        ]);

        $this->dispatch('success', message: 'Despatch Successfully!');
    }

    //Received
    public function received()
    {
        if($this->srinID){
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
        $this->items = SRIN::where('srin_id', $this->srinID)->get();
        $this->requisitionStore = SRIN::where('srin_id', $this->srinID)->pluck('station_id')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        // dd($this->srinID);
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-show')->with([
            'data' => SRIN::where('srin_id', $this->srinID)->first(),
            'fa_approval' => FAAprroval::where('reference', $this->reference)->first(),
            'hod_approval' => HODApproval::where('reference', $this->reference)->first(),
            'despatched' => Despatched::where('reference', $this->reference)->first(),
            'received' => Received::where('reference', $this->reference)->first(),
        ]);
    }
}
