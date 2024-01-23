<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\PurchaseOrders;
use App\Models\Item;
use App\Models\ApprovalPO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;


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
            ApprovalPO::where('purchase_order_id', $this->poID)->first()->update([
                'recommend_note' => $this->recommend_note,
                'recommended_action' => $this->recommended_action,
                'recommended_by' => auth()->user()->id,
                'date_recommended' => now()
            ]);
        }
        
    }

    //Approval
    public function approval()
    {
        // Validation
        // $this->validate();

        if($this->poID){
            ApprovalPO::where('purchase_order_id', $this->poID)->first()->update([
                'approved_note' => $this->approved_note,
                'approved_action' => $this->approved_action,
                'approved_by' => auth()->user()->id,
                'date_approved' => now()
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
            'actions' => ApprovalPO::where('purchase_order_id', $this->poID)->first(),
        ]);
    }
}
