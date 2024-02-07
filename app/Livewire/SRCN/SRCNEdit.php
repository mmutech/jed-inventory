<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;

class SRCNEdit extends Component
{
    public $title = 'Modify SRCN';

    #[Locked]
    public $srcnID;

    public $inputs = [''], $items, $unitOfMeasure;

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $itemIDs = [], 
    $srcn_code, $requisitioning_store, $storeID;
    
    public $unit = [], $quantity = [];

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
        foreach ($this->stock_codes as $key => $stockCode) {
            SRCNItem::where('id', $this->itemIDs[$key])->update([
                'srcn_id'       => $this->srcnID,
                'stock_code_id' => $stockCode,
                'unit'          => $this->units[$key],
                'required_qty'  => $this->quantities[$key],
                'updated_by'    => auth()->user()->id
            ]);
        }

        $this->dispatch('success', message: 'SRCN Updated!');
        return redirect()->to('/srcn-index');

    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->unitOfMeasure = Unit::latest()->get();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        $items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        if ($items->count() > 0) {

            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stock_codes[$key] = $data->stock_code_id;
                $this->units[$key] = $data->unit;
                $this->quantities[$key] = $data->required_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRCN Items Not Exist!');
            return redirect()->to('/srcn-index');
        }
        // Get Item for Confirmation
        // $items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        // if ($items->count() > 0) {
        //     foreach ($items as $key => $data) {
        //         $this->itemIDs[$key] = $data->id;
        //         $this->issued_qty[$key] = $data->issued_qty;
        //     }
        // } else {
        //     $this->dispatch('info', message: 'SRCN Items Not Exist!');
        //     return redirect()->to('/srcn-index');
        // }
 

        // dd($approved);
    }

    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-edit')->with([
            'items' => SRCNItem::where('srcn_id', $this->srcnID)->get(),
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
