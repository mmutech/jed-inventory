<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SRIN;
use App\Models\StockCode;
use App\Models\Store;

class SRINEdit extends Component
{
    public $title = 'Modify SRIN';

    // #[Locked]
    public $srinID;

    public $inputs = [''], $items;

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $descriptions = [], $itemIDs = [], 
    $srin_code, $requisitioning_store, $storeID;
    
    public $unit = [], $quantity = [], $description = [];

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
        // Update SRIN
        foreach ($this->stock_codes as $key => $stockCode) {
            SRIN::where('id', $this->itemIDs[$key])->update([
                'srin_id'           => $this->srinID,
                'stock_code_id'     => $stockCode,
                'unit'              => $this->units[$key],
                'required_qty'      => $this->quantities[$key],
                'description'       => $this->descriptions[$key],
                'updated_by'        => auth()->user()->id
            ]);
        }

        // Create SRIN
        // foreach ($this->stock_codes as $key => $stock_code) {
        //     SRIN::create([
        //         'srin_id'           => $this->srinID,
        //         'srin_code'         => 'SRIN-'.$this->srinID,
        //         'stock_code_id'     => $stock_code,
        //         'unit'              => $this->unit[$key],
        //         'required_qty'      => $this->quantity[$key],
        //         'description'       => $this->description[$key],
        //         'station_id'        => $this->storeID,
        //         'requisition_date'  => now(),
        //         'created_by'        => auth()->user()->id,
        //     ]);
        // }

        $this->dispatch('success', message: 'SRIN Updated!');
        return redirect()->to('/srin-index');

    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        $items = SRIN::where('srin_id', $this->srinID)->get();
        if ($items->count() > 0) {

            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stock_codes[$key] = $data->stock_code_id;
                $this->units[$key] = $data->unit;
                $this->quantities[$key] = $data->required_qty;
                $this->descriptions[$key] = $data->description;
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
        return view('livewire.s-r-i-n.s-r-i-n-edit')->with([
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
