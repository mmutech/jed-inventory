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

class ConfirmItem extends Component
{
    public $title = 'New SRA';

    #[Locked]
    public $poID;

    public $purchase_order_name, $purchase_order_no, $delivery_address, $vendor_name, $item;

    #[Rule('required')]
    public $consignment_note_no, $invoice_no, $purchase_order_id, $sraID, $received_note;

    #[Rule('required')]
    public $confirm_qtys = [], $confirm_rates = [], $stock_codes = [], $itemIDs = [];

    public function confirmed()
    {
        if (!SRARemark::where('sra_id', $this->sraID)->exists()) {
            // Create SRA
            SRA::create([
                'consignment_note_no' => $this->consignment_note_no,
                'invoice_no' => $this->invoice_no,
                'sra_code' => 'SRA-'.$this->sraID,
            ]);

             // SRA Remark
            SRARemark::create([
                'sra_id' => $this->sraID,
                'purchase_order_id' => $this->poID,
                'raised_date' => now(),
                'raised_by' => auth()->user()->id,
                'received_note' => $this->received_note,
                'received_by' => auth()->user()->id,
                'received_date' => now(),
            ]);

            //Confirm Items
            foreach ($this->confirm_qtys as $key => $confirm_qty) {
                Item::where('id', $this->itemIDs[$key])->update([
                    'confirm_qty' => $confirm_qty,
                    'confirm_rate' => $this->confirm_rates[$key],
                    'stock_code' => $this->stock_codes[$key],
                    'confirm_by' => Auth::user()->id
                ]);
            }

            $this->dispatch('success', message: 'Purchase Order Item Confirmed!');
            return redirect()->to('show-sra/' . $this->poID);

        }else {
            $this->dispatch('info', message: 'SRA Already Exist!');
            return redirect()->to('show-sra/' . $this->poID);
        }

    }

    public function mount($poID)
    {
        $this->poID = $poID;

        // Store Received Advice ID
        $lastRecord = SRA::latest()->first();
        $this->sraID = $lastRecord ? $lastRecord->sra_id + 1 : 1;

        // Get Purchase Order for display
        $purchase = PurchaseOrders::where('purchase_order_id', $this->poID)->first();

        if ($purchase) {
            $this->purchase_order_no = $purchase->purchase_order_no;
            $this->purchase_order_name = $purchase->purchase_order_name;
            $this->delivery_address = $purchase->delivery_address;
            $this->vendor_name = $purchase->vendor_name;
            $this->invoice_no = $purchase->invoice_no;
            $this->consignment_note_no = $purchase->consignment_note_no;
            // Add other properties as needed
        }

        // Get Item for Confirmation
        $items = Item::where('purchase_order_id', $this->poID)->get();
        if ($items->count() > 0) {

            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->confirm_qtys[$key] = $data->confirm_qty;
                $this->confirm_rates[$key] = $data->confirm_rate;
                $this->stock_codes[$key] = $data->stock_code;
            }
        } else {
            $this->dispatch('info', message: 'Purchase Order Items Not Exist!');
            return Redirect()->route('purchase-order-show', ['poID' => $this->editItemID]);
        }
 

        // dd($approved);
    }

    public function render()
    {
        return view('livewire.s-r-a.confirm-item')->with([
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
