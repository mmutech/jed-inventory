<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\StockCode;
use App\Models\StoreBinCard;
use Illuminate\Support\Facades\DB;


class SRCNIssue extends Component
{
    public $title = 'Quantity Issue';

    #[Locked]
    public $srcnID;

    public $hod_approved_note, $hod_approved_action, $reference, $items, $stockCodeIDs,
    $stockCode, $binCard, $stockCodeID, $balance, $available, $issueStore;

    public $issuedQty;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $stationIDs = [], $issuedItems = [], $storeID;

    public function issuingStore($station_id, $stockCodeID)
    {
        $binCard = StoreBinCard::where('station_id', $station_id)
            ->where('stock_code_id', $stockCodeID)
            ->where('balance', '>', 0)
            ->orderBy('created_at')
            ->first();

        // dd($this->issuedQty);
        if (!empty($binCard)) {
            IssuingStore::Create([
                'stock_code_id' => $stockCodeID,
                'reference'     => $this->reference,
                'station_id'    => $station_id,
                'quantity'      => $this->issuedQty,
            ]);
        }

        // SRCN::where('srcn_id', $this->srcnID)->first()->update([
        //     'issuing_store' => $station_id,
        //     // 'issue_date' => now(),
        //     'created_by' => auth()->user()->id,
        // ]); 

        // Check Store Bin Card
        // foreach ($this->items as $key => $item) {
        //     $binCard = StoreBinCard::where('stock_code_id', $item->stock_code_id)
        //             ->where('station_id', $station_id)
        //             ->where('balance', '>', 0)
        //             ->orderBy('created_at')
        //             ->first();

        //     // dd($binCard);

        //     if(!empty($binCard)){
        //         $issuedQty = min($item->issued_qty, $binCard->balance);

        //         // Update the oldest record
        //         $binCard->update([
        //             'out'          => $binCard->out + $issuedQty,
        //             'balance'      => $binCard->balance - $issuedQty,
        //             'date_issue'   => now(),
        //             'updated_by'   => auth()->user()->id,
        //         ]);

        //         StoreBinCard::create([
        //             'stock_code_id' => $item->stock_code_id,
        //             'unit'          => $item->unit,
        //             'reference'     => $this->reference,
        //             'station_id'    => $station_id,
        //             'in'            => $this->issued_qty[$key],
        //             'balance'       => $this->issued_qty[$key],
        //         ]);

        //         $remainingQty = $item->issued_qty - $issuedQty;
        //         while ($remainingQty > 0) {
        //             $nextBinCard = StoreBinCard::where('stock_code_id', $item->stock_code_id)
        //                 ->where('station_id', $station_id)
        //                 ->where('balance', '>', 0)
        //                 ->where('created_at', '>', $binCard->created_at)
        //                 ->orderBy('created_at')
        //                 ->first();
        
        //             if ($nextBinCard) {
        //                 $issuedQty = min($remainingQty, $nextBinCard->balance);
        
        //                 // Update the next record
        //                 $nextBinCard->update([
        //                     'out' => $nextBinCard->out + $issuedQty,
        //                     'balance' => $nextBinCard->balance - $issuedQty,
        //                     'date_issue' => now(),
        //                     'updated_by' => auth()->user()->id,
        //                 ]);
        
        //                 $remainingQty -= $issuedQty;
        //             } else {

        //                 break;
        //             }
        //         }
        //     }
        // }
    }

    public function update()
    {
        // HOD Approval and Issued by
        HODApproval::create([
            'reference'            => $this->reference,
            'hod_approved_note'    => $this->hod_approved_note,
            'hod_approved_action'  => $this->hod_approved_action,
            'hod_approved_by'      => auth()->user()->id,
            'hod_approved_date'    => now()
        ]);

        $this->dispatch('success', message: 'Item Issued Successfully!');
        return redirect()->to('srcn-show/' . $this->srcnID);

    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->stockCodeIDs = SRCNItem::where('srcn_id', $this->srcnID)->pluck('stock_code_id');  

         // Get the Issue Store
         $this->issueStore = StoreBinCard::whereIn('stock_code_id', $this->stockCodeIDs)
         ->groupBy('stock_code_id', 'station_id')
         ->select('stock_code_id', 'station_id', DB::raw('sum(balance) as total_balance'))
         ->get();
 
         // Get the SRCN Item
         $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();

        if ($this->items->count() > 0) {
            foreach ($this->items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stationIDs[$key] = $data->station_id;
                $this->issued_qty[$key] = $data->issued_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRCN Items Not Exist!');
            return redirect()->to('srcn-show/' . $this->srcnID);
        }
    }
    
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-issue')->with([
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
