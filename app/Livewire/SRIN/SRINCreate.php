<?php

namespace App\Livewire\SRIN;

use App\Models\location;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SRIN;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;

class SRINCreate extends Component
{
    public $title = 'Create SRIN';

    public $inputs = [''], $unitOfMeasure;

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $descriptions = [], 
    $srin_code, $requisitioning_store, $storeID, $srinID, $locations;

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
        $lastRecord = SRIN::latest()->first();
        $this->srinID = $lastRecord ? $lastRecord->srin_id + 1 : 1;

        // Create SRIN
        foreach ($this->stock_codes as $key => $stock_code) {
            SRIN::create([
                'srin_id'           => $this->srinID,
                'srin_code'         => 'SRIN-'.$this->srinID,
                'stock_code_id'     => $stock_code,
                'location'          => $this->locations,
                'unit'              => $this->units[$key],
                'required_qty'      => $this->quantities[$key],
                'description'       => $this->descriptions[$key],
                'requisition_date'  => now(),
                'created_by'        => auth()->user()->id,
            ]);
        }

        $this->dispatch('success', message: 'SRIN Initiated!');

        return redirect()->to('/srin-index');
    }

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->unitOfMeasure = Unit::latest()->get();
        // dd($this->storeID);
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-create')->with([
            'stock_code' => StockCode::where('status', 'Active')->latest()->get(),
            'location' => location::where('status', 'Active')->latest()->get(),
        ]);
    }
}
