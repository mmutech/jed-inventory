<?php

namespace App\Livewire\SRCN;

use App\Models\Approvals;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\StockCode;
use App\Models\Store;

class SRCNIssue extends Component
{
    public $title = 'Quantity Issue';

    #[Locked]
    public $srcnID;

    public $recommend_action, $recommend_note, $approved_note, $approved_action, $reference;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $storeID;

    public function update()
    {
        // if (!SRCN::where('issuing_store', $this->poID)->exists()) {

         //Confirm Items
        foreach ($this->issued_qty as $key => $issued_qtys) {
            SRCNItem::where('id', $this->itemIDs[$key])->update([
                'issued_qty' => $issued_qtys,
            ]);
        }

        if($this->srcnID){
            Approvals::create([
                'reference'         => $this->reference,
                'approved_note'    => $this->approved_note,
                'approved_action'  => $this->approved_action,
                'approved_by'      => auth()->user()->id,
                'approved_date'    => now()
            ]);
        }

        $this->dispatch('success', message: 'Item Issue Successfully!');
        return redirect()->to('srcn-show/' . $this->srcnID);

    // }else {
    //     $this->dispatch('info', message: 'Item Already Issued!');
    //     return redirect()->to('srcn-show/' . $this->srcnID);
    // }

    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();

        // Get Item for Confirmation
        $items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        if ($items->count() > 0) {
            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->issued_qty[$key] = $data->issued_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRCN Items Not Exist!');
            return redirect()->to('srcn-show/' . $this->srcnID);
        }
 

        // dd($approved);
    }
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-issue')->with([
            'items' => SRCNItem::where('srcn_id', $this->srcnID)->get(),
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
