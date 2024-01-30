<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\HODApproval;
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

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $storeID;

    public function issuingStore($station_id)
    {
        SRCN::where('srcn_id', $this->srcnID)->first()->update([
            'issuing_store' => $station_id,
            // 'issue_date' => now(),
            'created_by' => auth()->user()->id,
        ]); 
    }

    public function update()
    {
        //Issue Items
        foreach ($this->issued_qty as $key => $issued_qtys) {
            SRCNItem::where('id', $this->itemIDs[$key])->update([
                'issued_qty' => $issued_qtys,
            ]);
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
    
        // dd($this->items);

        // Get Item for Confirmation
        $this->items = SRCNItem::select('s_r_c_n_items.stock_code_id', 's_r_c_n_items.required_qty', 's_r_c_n_items.unit', 's_r_c_n_items.issued_qty', 's_r_c_n_items.id', DB::raw('sum(store_bin_cards.balance) as total_balance'))
        ->join('store_bin_cards', 'store_bin_cards.stock_code_id', '=', 's_r_c_n_items.stock_code_id')
        ->where('s_r_c_n_items.srcn_id', $this->srcnID)
        ->groupBy('s_r_c_n_items.stock_code_id', 's_r_c_n_items.required_qty', 's_r_c_n_items.unit', 's_r_c_n_items.issued_qty', 's_r_c_n_items.id')
        ->get();
        if ($this->items->count() > 0) {
            foreach ($this->items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
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
