<?php

namespace App\Livewire\SCN;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SCN;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;
use App\Models\location;

class SCNEdit extends Component
{
    public $title = 'Modify SCN';

    #[Rule('required')]
    public $stock_codes = [], $units = [], $quantities = [], $itemIDs = [], 
    $locations, $unitOfMeasure, $storeID, $scnID;

    public function update()
    {

        // Create SRIN
        foreach ($this->stock_codes as $key => $stock_code) {
            SCN::where('id', $this->itemIDs[$key])->update([
                'scn_id'            => $this->scnID,
                'stock_code_id'     => $stock_code,
                'job_from'          => $this->locations,
                'unit'              => $this->units[$key],
                'quantity'          => $this->quantities[$key],
                'updated_by'        => auth()->user()->id
            ]);
        }

        $this->dispatch('success', message: 'SCN Updated!');

        return redirect()->to('/scn-index');
    }

    public function mount($scnID)
    {
        $this->scnID = $scnID;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->unitOfMeasure = Unit::latest()->get();

        $items = SCN::where('scn_id', $this->scnID)->get();
        if ($items->count() > 0) {

            foreach ($items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stock_codes[$key] = $data->stock_code_id;
                $this->locations = $data->job_from;
                $this->units[$key] = $data->unit;
                $this->quantities[$key] = $data->quantity;
            }
        } else {
            $this->dispatch('info', message: 'SCN Items Not Exist!');
            return redirect()->to('/scn-index');
        }

    }

    public function render()
    {
        return view('livewire.s-c-n.s-c-n-edit')->with([
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
            'location' => location::where('status', 'Active')->latest()->get(),
        ]);
    }
}
