<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EditItem extends Component
{
    
    public $title = 'Modify Items';

    public $editItemID, $key, $itemID;

    public $inputs = [''], $items;
    public $description = [], $unit = [], $quantity = [], $rate = [];

    #[Rule('required')]
    public $descriptions = [], $units = [], $quantities = [], $rates = [], $itemIDs = [];

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

    public function update()
    {
        foreach ($this->descriptions as $key => $description) {
            Item::where('id', $this->itemIDs[$key])->update([
                'description' => $description,
                'unit' => $this->units[$key],
                'quantity' => $this->quantities[$key],
                'rate' => $this->rates[$key],
                'updated_by' => Auth::user()->id
            ]);
        }

        foreach ($this->description as $key => $descriptions) {
            Item::create([
                'purchase_order_id' => $this->editItemID,
                'description' => $descriptions,
                'unit' => $this->unit[$key],
                'quantity' => $this->quantity[$key],
                'rate' => $this->rate[$key],
            ]);
        }

        $this->dispatch('info', message: 'Purchase Order Updated!');

        return redirect()->to('purchase-order-show/' . $this->editItemID);
    }

    public function mount($editItemID)
    {
        $this->editItemID = $editItemID;

        // Edit
        $items = Item::where('purchase_order_id', $this->editItemID)->get();
        if ($items->count() > 0) {

            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->descriptions[$key] = $data->description;
                $this->units[$key] = $data->unit;
                $this->quantities[$key] = $data->quantity;
                $this->rates[$key] = $data->rate;
            }
        } else {
            $this->dispatch('info', message: 'Purchase Order Items Not Exist!');
            return Redirect()->route('purchase-order-show', ['poID' => $this->editItemID]);
        }

    }

    public function render()
    {
        return view('livewire.purchase-order.edit-item');
    }
}
