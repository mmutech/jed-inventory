<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Models\SRA;
use App\Models\PurchaseOrders;
use App\Models\Item;
use App\Models\StockCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ConfirmItem extends Component
{
    use WithFileUploads;

    public $title = 'New SRA';

    public $step = 1;

    #[Locked]
    public $poID;

    public $purchase_order_name, $purchase_order_no, $delivery_address, $vendor_name, $item,
    $purchase_order_id, $sraID, $received_note, $search;

    #[Rule('required')]
    public $consignment_note_no, $invoice_no;

    #[Rule('required|image|max:1024')]
    public $quality_cert, $delivery_note, $invoice_doc;

    // #[Rule('required')]
    public $quantity = [], $confirm_qtys = [], $confirm_rates = [], $stock_codes = [], $itemIDs = [];

    public function nextStep()
    {
        $this->validate();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function confirmed()
    {
        $this->validate([
            'stock_codes'       => ['required'],
        ]);

        if (!SRA::where('purchase_order_id', $this->poID)->exists()) {
            $deliveryNote = $this->delivery_note->store('deliveryNote', 'public');
            $invoiceDoc = $this->invoice_doc->store('invoiceDoc', 'public');
            $qualityCert = $this->quality_cert->store('qualityCert', 'public');
            // Create SRA
            SRA::create([
                'sra_id' => $this->sraID,
                'consignment_note_no' => $this->consignment_note_no,
                'invoice_no' => $this->invoice_no,
                'sra_code' => 'SRA-'.$this->sraID,
                'purchase_order_id' => $this->poID,
                'delivery_note' => $deliveryNote,
                'invoice_doc' => $invoiceDoc,
                'quality_cert' => $qualityCert,
                'received_date' => now(),
                'created_by' => Auth::user()->id
            ]);

            //Confirm Items
            foreach ($this->itemIDs as $key => $itemIDs) {
                Item::where('id', $itemIDs)->update([
                    'stock_code' => $this->stock_codes[$key],
                ]);
            }

            $this->dispatch('success', message: 'SRA Created!');
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
            $this->delivery_address = $purchase->storeID->name;
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
                $this->quantity[$key] = $data->quantity;
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
            'stock_code' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
