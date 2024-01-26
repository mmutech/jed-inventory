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

class EditSra extends Component
{
    public $title = 'Modify SRA';

    public $invoice_no, $consignment_note_no, $purchase_order_no;

    #[Locked]
    public $sraID;

    public function update()
    {
        if ($this->sraID) {
            SRA::where('id', $this->sraID)->first()->update([
                'consignment_note_no' => $this->consignment_note_no,
                'invoice_no' => $this->invoice_no,
                'updated_by' => Auth::user()->id
            ]);

            $this->dispatch('info', message: 'SRA Updated!');

            return redirect()->to('show-sra/' . $this->sraID);
        }
    }

    public function mount($sraID)
    {
        $this->sraID = $sraID;

        // Get SRA for display
        $sra = SRA::where('id', $this->sraID)->first();

        if ($sra) {
            $this->consignment_note_no = $sra->consignment_note_no;
            $this->invoice_no = $sra->invoice_no;
            $this->purchase_order_no = $sra->purchaseOrderID->purchase_order_no;
        }
    }

    public function render()
    {
        return view('livewire.s-r-a.edit-sra');
    }
}
