<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use App\Models\StoreBinCard;
use App\Models\SRARemark;
use App\Models\PurchaseOrders;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ShowSra extends Component
{
    public $title = 'New SRA';
    public $items, $reference;

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

             // Create Store Bin Card
             foreach ($this->items as $item) {
                if (isset($item->stock_code, $item->purchase_order_id, $item->quantity)) {
                    StoreBinCard::create([
                        'stock_code_id' => $item->stock_code,
                        'reference'     => $this->reference,
                        'station_id'    => $item->purchase_order_id,
                        'in'            => $item->quantity,
                        'balance'       => $item->quantity,
                        'date_receipt'  => now(),
                        'created_by'    => Auth::user()->id,
                    ]);
                } else {

                }
            }

            $this->dispatch('info', message: 'SRA Approved By Account Operation!');
        }
    }

    public function mount($poID)
    {
        $this->poID = $poID;
        $this->items = Item::where('purchase_order_id', $poID)->get();
        $this->reference = SRARemark::where('purchase_order_id', $poID)->pluck('sra_id')->first();
        //dd($this->reference);
    }

    public function render()
    {
        return view('livewire.s-r-a.show-sra')->with([
            'data' => SRARemark::where('purchase_order_id', $this->poID)->first(),
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
