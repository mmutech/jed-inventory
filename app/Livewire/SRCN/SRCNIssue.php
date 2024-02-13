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

    public $issuedQty, $issuedQuantity;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $stationIDs = [], $issuedItems = [], $storeID;

    public function issuingStore($station_id, $stockCodeID)
    {
        // dd($this->issuedQty);
        if (!empty($station_id)) {
            IssuingStore::Create([
                'stock_code_id' => $stockCodeID,
                'reference'     => $this->reference,
                'station_id'    => $station_id,
                'quantity'      => $this->issuedQty,
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

        $srcnItem = SRCNItem::where('srcn_id', $this->srcnID)
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->get();

        // dd($issuedQuantity);

        if (!empty($issuedQuantity)) {
            foreach ($issuedQuantity as $issued_qtys) {
                foreach($srcnItem as $value){
                    // dd($value->stock_code_id);
                    if ($value->stock_code_id == $issued_qtys->stock_code_id) {
                        SRCNItem::where('id', $value->id)->update([
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
            return redirect()->to('srcn-show/' . $this->srcnID);

        }else{
            $this->dispatch('danger', message: 'Item Issued Not Found!');
        }
    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->stockCodeIDs = SRCNItem::where('srcn_id', $this->srcnID)->pluck('stock_code_id'); 
        // dd($this->issuedQuantity);

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
