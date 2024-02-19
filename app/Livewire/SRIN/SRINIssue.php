<?php

namespace App\Livewire\SRIN;

use App\Models\HODApproval;
use App\Models\IssuingStore;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRIN;
use App\Models\StoreBinCard;
use Illuminate\Support\Facades\DB;

class SRINIssue extends Component
{
    public $title = 'Quantity Issue';

    #[Locked]
    public $srinID;

    public $hod_approved_note, $hod_approved_action, $reference, $items, $stockCodeIDs,
    $stockCode, $binCard, $stockCodeID, $balance, $available, $issueStore, $calculatedResults;

    public $issuedQty = [], $issuedQuantity;

    public function issuingStore($issued_key, $station_id, $stockCodeID)
    {
        if (!empty($station_id)) {
            
            IssuingStore::Create([
                //'bin_card_id'
                'stock_code_id' => $stockCodeID,
                'reference'     => $this->reference,
                'station_id'    => $station_id,
                'quantity'      => $this->issuedQty[$issued_key],
            ]);

        } 
     
    }

    public function update()
    {
         // Issue Quantity
         $issuedQuantity = IssuingStore::where('reference', $this->reference)
         ->whereIn('stock_code_id', $this->stockCodeIDs)
         ->groupBy('stock_code_id')
         ->select('stock_code_id', DB::raw('sum(quantity) as total_quantity'))
         ->get();

        $srinItem = SRIN::where('srin_id', $this->srinID)
        ->whereIn('stock_code_id', $this->stockCodeIDs)
        ->get();


        if (!empty($issuedQuantity)) {
            foreach ($issuedQuantity as $issued_qtys) {
                foreach($srinItem as $value){
                    // dd($value->stock_code_id);
                    if ($value->stock_code_id == $issued_qtys->stock_code_id) {
                        SRIN::where('id', $value->id)->update([
                            'issued_qty' => $issued_qtys->total_quantity,
                        ]);
                    }
                }
            }

            // HOD Approval and Issued by
            HODApproval::create([
                'reference'            => $this->reference,
                'hod_approved_note'    => $this->hod_approved_note,
                'hod_approved_action'  => $this->hod_approved_action,
                'hod_approved_by'      => auth()->user()->id,
                'hod_approved_date'    => now()
            ]);

            $this->dispatch('success', message: 'Item Issued Successfully!');
            return redirect()->to('srin-show/' . $this->srinID);

        }else{
            $this->dispatch('danger', message: 'Item Issued Not Found!');
        }

    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 
    
        // dd($this->items);

        // Get the Issue Store
        $this->issueStore = StoreBinCard::whereIn('stock_code_id', $this->stockCodeIDs)
        ->groupBy('stock_code_id', 'station_id')
        ->select('stock_code_id', 'station_id', DB::raw('sum(balance) as total_balance'))
        ->get();

        $this->items = SRIN::where('srin_id', $this->srinID)->get();

    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-issue');
    }
}
