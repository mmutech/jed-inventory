<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Models\PurchaseOrders;
use App\Models\Item;
use App\Models\ApprovalPO;
use App\Models\Approvals;
use App\Models\Recommendations;


class Show extends Component
{
    public $title = 'Details';

    #[Locked]
    public $poID;

    public $recommended_action, $recommend_note, $approved_note, $approved_action;

    //Recommendation
    public function recommends()
    {
        // Validation
        // $this->validate();
    
        if($this->poID){
            Recommendations::create([
                'reference'         => $this->poID,
                'recommend_note'    => $this->recommend_note,
                'recommend_action'  => $this->recommended_action,
                'recommend_by'      => auth()->user()->id,
                'recommend_date'    => now()
            ]);
        }
        
    }

    //Approval
    public function approval()
    {
        // Validation
        // $this->validate();

        if($this->poID){
            Approvals::create([
                'reference'         => $this->poID,
                'approved_note'     => $this->approved_note,
                'approved_action'   => $this->approved_action,
                'approved_by'       => auth()->user()->id,
                'approved_date'     => now()
            ]);
        }

        PurchaseOrders::where('purchase_order_id', $this->poID)->update([
            'status' => 'Approved',
        ]);

    }

    public function mount($poID)
    {
        $this->poID = $poID;

    }

    public function render()
    {
        return view('livewire.purchase-order.show')->with([
            'data' => PurchaseOrders::where('purchase_order_id', $this->poID)->first(),
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
            'recommend' => Recommendations::where('reference', $this->poID)->first(),
            'approval' => Approvals::where('reference', $this->poID)->first(),
        ]);
    }
}
