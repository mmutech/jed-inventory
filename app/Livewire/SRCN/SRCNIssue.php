<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 

use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\Despatched;
use App\Models\IssuingStore;
use App\Models\location;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\StoreLedger;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SRCNIssue extends Component
{
    public $title = 'SRCN Issue';

    #[Locked]
    public $srcnID, $locations;

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
            ->orderBy('created_at', 'desc')
            ->first();

        while ($binCard !== null && $binCard->out == $binCard->in) {
            // Skip the current record and fetch the next one
            $binCard = StoreBinCard::where('station_id', $station_id)
                ->where('stock_code_id', $stockCodeID)
                ->where('balance', '>', 0)
                ->where('created_at', '>', $binCard->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if ($binCard !== null) {
            StoreBinCard::create([
                'stock_code_id' => $binCard->stock_code_id,
                'reference'     => $this->reference,
                'station_id'    => $station_id,
                'out'           => $this->issuedQty[$issued_key],
                'balance'       => $binCard->balance - $this->issuedQty[$issued_key],
                'date_receipt'  => now(),
                'updated_by'    => auth()->user()->id,
            ]);

            //Store Ledger
            $storeLedger = StoreLedger::where('station_id', $station_id)
                ->where('stock_code_id', $stockCodeID)
                ->where('qty_balance', '>', 0)
                ->orderBy('created_at', 'desc')
                ->first();

            while ($storeLedger !== null && $storeLedger->qty_issue == $storeLedger->qty_receipt) {
                // Skip the current record and fetch the next one
                $storeLedger = StoreLedger::where('station_id', $station_id)
                    ->where('stock_code_id', $stockCodeID)
                    ->where('qty_balance', '>', 0)
                    ->where('created_at', '>=', $storeLedger->created_at)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $current_out = $storeLedger->basic_price * $this->issuedQty[$issued_key];
            // dd($current_out);
            
            if ($storeLedger !== null){
  
                StoreLedger::create([
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'basic_price'           => $storeLedger->basic_price,
                    'station_id'            => $station_id,
                    'qty_issue'             => $this->issuedQty[$issued_key],
                    'qty_balance'           => $storeLedger->qty_balance - $this->issuedQty[$issued_key],
                    'value_out'             => $current_out,
                    'value_balance'         => $storeLedger->value_balance - $current_out,
                    'unit'                  => $storeLedger->unit,
                    'date'                  => now(),
                    'created_by'            => Auth::user()->id,
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
        return redirect()->to('srcn-show/' . $this->srcnID);
    }

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->locations  = location::where('status', 'Active')->latest()->get();
        $this->storeID   = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->stockCodeIDs = SRCNItem::where('srcn_id', $this->srcnID)->pluck('stock_code_id'); 

        // Get the Issue Store
        $subquery = StoreBinCard::select('stock_code_id', DB::raw('MAX(created_at) as max_created_at'))
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->where('station_id', $this->storeID)
            ->groupBy('station_id', 'stock_code_id');
    
        $this->issueStore = StoreBinCard::joinSub($subquery, 'latest_records', function ($join) {
                $join->on('store_bin_cards.stock_code_id', '=', 'latest_records.stock_code_id');
                $join->on('store_bin_cards.created_at', '=', 'latest_records.max_created_at');
            })
            ->select('store_bin_cards.stock_code_id', 'store_bin_cards.station_id', 'store_bin_cards.balance as total_balance', 'store_bin_cards.created_at')
            ->get();

        // dd($this->issueStore);

        // Get the SRCN Item
        $this->items = IssuingStore::where('reference', $this->reference)
        ->where('station_id', $this->storeID)
        ->whereIn('stock_code_id', $this->stockCodeIDs)->get();

        // dd($this->storeID);
    

        if ($this->items->count() > 0) {
            foreach ($this->items as $key => $data) {
                $this->itemIDs[$key] = $data->id;
                $this->stationIDs[$key] = $data->station_id;
                $this->issued_qty[$key] = $data->issued_qty;
            }
        } else {
            $this->dispatch('info', message: 'SRCN Items Not Exist!');
            return redirect()->to('srcn-show/' . $this->srcnID);
        }
    }
    
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-issue')->with([
            'stockCode' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
