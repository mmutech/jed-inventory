<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\PurchaseOrders;
use App\Models\Item;
use App\Models\ApprovalPO;
use App\Models\Store;
use App\Models\Unit;

class Create extends Component
{
    public $title = 'Create New', $unitOfMeasure;

    public $inputs = [''];

    public $activeTab;


    #[Rule('required')]
    public $descriptions = [], $units = [], $delivery_address, $vendor_name, $beneficiary, 
           $purchase_order_name, $purchase_order_no;

    #[Rule('required')]
    public $quantities = [], $rates = [];

    public function addInput()
    {
        $this->inputs[] = '';
    }

    public function removeInput($key)
    {
        if ($key !== 0) {
            unset($this->inputs[$key]);
            $this->inputs = array_values($this->inputs);
        }
    }

    public function store()
    {
        $this->validate();

        // Purchase Order ID
        $lastRecord = PurchaseOrders::latest()->first();
        $poID = $lastRecord ? $lastRecord->purchase_order_id + 1 : 1;

        $poNo = $this->purchase_order_no;

        if (!PurchaseOrders::where('purchase_order_no', $poNo)->exists()) {
            PurchaseOrders::create([
                'purchase_order_no' => $this->purchase_order_no,
                'purchase_order_name' => $this->purchase_order_name,
                'beneficiary' => $this->beneficiary,
                'vendor_name' => $this->vendor_name,
                'delivery_address' => $this->delivery_address,
                'purchase_order_date' => now(),
                'purchase_order_id' => $poID,
                'created_by' => auth()->user()->id,
            ]); 

            // Items
            foreach ($this->descriptions as $key => $description) {
                Item::create([
                    'purchase_order_id' => $poID,
                    'description' => $description,
                    'unit' => $this->units[$key],
                    'quantity' => $this->quantities[$key],
                    'rate' => $this->rates[$key],
                ]);
            }

            $this->dispatch('success', message: 'Purchase Order Initiated!');

            return redirect()->to('/purchase-order');

        }else {
            $this->dispatch('info', message: 'Purchase Order Already Exist!');
        }
    }
    
    public function mount()
    {
        $this->activeTab = $this->activeTab ??  'dstepper-block';
        $this->unitOfMeasure = Unit::latest()->get();

    }

    public function render()
    {
        return view('livewire.purchase-order.create')->with([
            'stations'  => Store::where('status', 'Active')->latest()->get(),
        ]);
    }
}
