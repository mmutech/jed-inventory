<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\PurchaseOrders;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $title = 'Modify', $editPoID;
    #[Rule('required')]
    public $delivery_address, $vendor_name, $beneficiary, 
           $purchase_order_name, $purchase_order_no, $purchase_order_id;

    public function mount($editPoID)
    {
        $this->editPoID = $editPoID;

        //Edit
        $purchase = PurchaseOrders::where('purchase_order_id', $this->editPoID)->first();
        if ($purchase) {
            $this->purchase_order_id = $purchase->purchase_order_id;
            $this->purchase_order_no = $purchase->purchase_order_no;
            $this->purchase_order_name = $purchase->purchase_order_name;
            $this->vendor_name = $purchase->vendor_name;
            $this->delivery_address = $purchase->delivery_address;
            $this->beneficiary = $purchase->beneficiary;

        }else{
            return redirect()->to('/exit-initiation');
        }

    }

    public function update()
    {
        if ($this->editPoID) {
            PurchaseOrders::where('purchase_order_id', $this->editPoID)->first()->update([
                'purchase_order_no' => $this->purchase_order_no,
                'purchase_order_name' => $this->purchase_order_name,
                'vendor_name' => $this->vendor_name,
                'delivery_address' => $this->delivery_address,
                'beneficiary' => $this->beneficiary,
                'updated_by' => Auth::user()->id
            ]);

            $this->dispatch('info', message: 'Purchase Order Updated!');

            return redirect()->to('purchase-order-show/' . $this->editPoID);

        }
    }
    
    public function render()
    {
        return view('livewire.purchase-order.edit')->with([
            'stations' => Store::where('status', 'Active')->latest()->get(),
        ]);
    }
}
