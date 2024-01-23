<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Models\SRA;
use App\Models\SRARemark;
use App\Models\PurchaseOrders;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ShowSra extends Component
{
    public $title = 'New SRA';

    #[Rule('required')]
    public $account_operation_remark_date, $account_operation_remark_by, $account_operation_action, $account_operation_remark_note;

    #[Locked]
    public $poID;

    public function approved()
    {
        // Validation
        // $this->validate();

        // Remark by Account Operations
        if ($this->poID) {
            SRARemark::where('purchase_order_id', $this->poID)->first()->update([
                'account_operation_action' => $this->account_operation_action,
                'account_operation_remark_note' => $this->account_operation_remark_note,
                'account_operation_remark_date' => now(),
                'account_operation_remark_by' => Auth::user()->id
            ]);

            // Updated Purchase Order Status
            PurchaseOrders::where('purchase_order_id', $this->poID)->first()->update([
                'status' => 'Completed',
            ]);


            $this->dispatch('info', message: 'SRA Approved By Account Operation!');
        }
    }

    public function mount($poID)
    {
        $this->poID = $poID;

        // dd($approved);
    }

    public function render()
    {
        return view('livewire.s-r-a.show-sra')->with([
            'data' => SRARemark::where('purchase_order_id', $this->poID)->first(),
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
