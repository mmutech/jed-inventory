<?php

namespace App\Livewire\SCN;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SCN;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;
use App\Models\location;

class SCNCreate extends Component
{
    public $title = 'Create SCN';

    public $inputs = [''], $unitOfMeasure;

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $jobfrom = [], 
    $scn_code, $station_id, $storeID, $scnID, $locations;

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
        $lastRecord = SCN::latest()->first();
        $this->scnID = $lastRecord ? $lastRecord->scn_id + 1 : 1;

        // Create SRIN
        foreach ($this->stock_codes as $key => $stock_code) {
            SCN::create([
                'scn_id'            => $this->scnID,
                'scn_code'          => 'SCN-'.$this->scnID,
                'stock_code_id'     => $stock_code,
                'job_from'          => $this->locations,
                'unit'              => $this->units[$key],
                'quantity'          => $this->quantities[$key],
                'created_by'        => auth()->user()->id,
            ]);
        }

        $this->dispatch('success', message: 'SCN Initiated!');

        return redirect()->to('/scn-index');
    }

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->unitOfMeasure = Unit::latest()->get();
        // dd($this->storeID);
    }

    public function render()
    {
        return view('livewire.s-c-n.s-c-n-create')->with([
            'stock_code' => StockCode::where('status', 'Active')->latest()->get(),
            'location' => location::where('status', 'Active')->latest()->get(),
        ]);
    }
}
