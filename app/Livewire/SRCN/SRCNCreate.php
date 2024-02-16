<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SRCN;
use App\Models\Item;
use App\Models\SRCNItem;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;

class SRCNCreate extends Component
{
    public $title = 'Create SRCN';

    public $unitOfMeasure, $search;

    public $inputs = [''];

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $srcn_code, $requisitioning_store, $storeID, $srcnID;

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
        // $this->validate();
        $lastRecord = SRCN::latest()->first();
        $this->srcnID = $lastRecord ? $lastRecord->srcn_id + 1 : 1;

        dd($this->stock_codes);
        
        SRCN::create([
            'srcn_id' => $this->srcnID,
            'srcn_code' => 'SRCN-'.$this->srcnID,
            'requisitioning_store' => $this->storeID,
            'requisition_date' => now(),
            'created_by' => auth()->user()->id,
        ]); 

        // Items
        foreach ($this->stock_codes as $key => $stock_code) {
            SRCNItem::create([
                'srcn_id' => $this->srcnID,
                'stock_code_id' => $stock_code,
                'unit' => $this->units[$key],
                'required_qty' => $this->quantities[$key],
            ]);
        }

        $this->dispatch('success', message: 'SRCN Initiated!');

        return redirect()->to('/srcn-index');
    }

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->unitOfMeasure = Unit::latest()->get();
        // dd($this->storeID);
    }

    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-create')->with([
            'stock_code' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
