<?php

namespace App\Livewire\SRIN;

use App\Models\Despatched;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 
use App\Models\SRIN;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class SRINIssue extends Component
{
    public $title = 'Quantity Issue';

    #[Locked]
    public $srinID;

    public $reference, $items, $stockCodeIDs,
    $stockCode, $binCard, $stockCodeID, $balance, $available, $issueStore, $lorry_no, 
    $despatched_note, $driver_name, $location;

    public $issuedQty = [], $issuedQuantity;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $stationIDs = [], $issuedItems = [], $storeID;

    public function issuingStore($issued_key, $station_id, $stockCodeID)
    {
        $binCard = StoreBinCard::where('station_id', $station_id)
        ->where('stock_code_id', $stockCodeID)
        ->where('balance', '>', 0)
        ->orderBy('created_at')
        ->get();
        
        // dd($binCard);

        if (!empty($binCard)) {
            foreach ($binCard as $value) {
                StoreBinCard::where('id', $value->id)->update([
                    'out'        => $value->out + $this->issuedQty[$issued_key],
                    'balance'    => $value->balance - $this->issuedQty[$issued_key],
                    'updated_by' => auth()->user()->id,
                ]);
            }

            $this->dispatch('success', message: 'Issued Successfully!');
        } else {
            $this->dispatch('danger', message: 'Issue Fails!');
        }
     
    }

    public function update()
    {
        // Despatched
        Despatched::create([
            'reference'          => $this->reference,
            'store_id'           => $this->storeID,
            'despatched_note'    => $this->despatched_note,
            'despatched_by'      => auth()->user()->id,
            'despatched_date'    => now()
        ]);

        // Vehicle and Drivers Info
        Vehicle::create([
            'reference'         => $this->reference,
            'lorry_no'          => $this->lorry_no,
            'driver_name'       => $this->driver_name,
            'location'          => $this->location,
            'store_id'          => $this->storeID,
            'created_by'        => auth()->user()->id,
            'vehicle_date'      => now()
        ]);

        $this->dispatch('success', message: 'Issued and Despatched Successfully!');
        return redirect()->to('srin-show/' . $this->srinID);
    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 

        // Get the Issue Store
        $this->issueStore = StoreBinCard::whereIn('stock_code_id', $this->stockCodeIDs)
        ->where('station_id', $this->storeID)
        ->groupBy('stock_code_id', 'station_id')
        ->select('stock_code_id', 'station_id', DB::raw('sum(balance) as total_balance'))
        ->get();

        // dd($this->reference);

        // Get the SRiN Item
        $this->items = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)
        ->whereIn('stock_code_id', $this->stockCodeIDs)->get();

        // dd($this->items);
       
        if ($this->items->count() > 0) {
            foreach ($this->items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stationIDs[$key] = $data->station_id;
                $this->issued_qty[$key] = $data->issued_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRiN Items Not Exist!');
            return redirect()->to('srin-show/' . $this->srinID);
        }
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-issue');
    }
}
