<?php

namespace App\Livewire\SRIN;

use App\Models\HODApproval;
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
    $stockCode, $binCard, $stockCodeID, $balance, $available;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $storeID;

    public function update()
    {
        //Issue Items
        foreach ($this->issued_qty as $key => $issued_qtys) {
            SRIN::where('id', $this->itemIDs[$key])->update([
                'issued_qty' => $issued_qtys,
                'issue_date' => now(),
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
                return redirect()->to('srin-show/' . $this->srinID);

    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 
    
        // dd($this->items);

        // Get Item for Confirmation
        // $this->items = SRIN::select('s_r_i_n_s.stock_code_id', 's_r_i_n_s.required_qty', 's_r_i_n_s.unit', 's_r_i_n_s.issued_qty', 's_r_i_n_s.id', DB::raw('sum(store_bin_cards.balance) as total_balance'))
        // ->join('store_bin_cards', 'store_bin_cards.stock_code_id', '=', 's_r_i_n_s.stock_code_id')
        // ->where('s_r_i_n_s.srin_id', $this->srinID)
        // ->groupBy('s_r_i_n_s.stock_code_id', 's_r_i_n_s.required_qty', 's_r_i_n_s.unit', 's_r_i_n_s.issued_qty', 's_r_i_n_s.id')
        // ->get();

        $this->items = SRIN::where('srin_id', $this->srinID)->get();

        // dd($this->items);
        if ($this->items->count() > 0) {
            foreach ($this->items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->issued_qty[$key] = $data->issued_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRIN Items Not Exist!');
            return redirect()->to('srin-show/' . $this->srinID);
        }
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-issue');
    }
}
