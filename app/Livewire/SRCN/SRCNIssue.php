<?php

namespace App\Livewire\SRCN;

use App\Models\Allocation;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule; 

use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\Despatched;
use App\Models\IssuingStore;
use App\Models\Item;
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

    public $reference, $items, $stockCodeIDs, $requisitionStore,
    $stockCode, $binCard, $stockCodeID, $balance, $available, $issueStore, $lorry_no, 
    $despatched_note, $driver_name, $location;

    public $issuedQty = [], $issuedQuantity;

    #[Rule('required')]
    public $issued_qty = [], $itemIDs = [], $stationIDs = [], $issuedItems = [], $storeID;

    public function issuingStore($issued_key, $station_id, $stockCodeID)
    {
        $binCard = StoreBinCard::where('station_id', $station_id)
            ->where('stock_code_id', $stockCodeID)
            ->orderBy('created_at', 'desc')
            ->first();

        while ($binCard !== null && $binCard->out == $binCard->in) {
            // Skip the current record and fetch the next one
            $binCard = StoreBinCard::where('station_id', $station_id)
                ->where('stock_code_id', $stockCodeID)
                ->where('created_at', '>', $binCard->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if ($binCard !== null) {
            //Create Store Bin Card
            StoreBinCard::create([
                'purchase_order_id'     => $binCard->purchase_order_id,
                'stock_code_id'         => $binCard->stock_code_id,
                'unit'                  => $binCard->unit,
                'reference'             => $this->reference,
                'station_id'            => $station_id,
                'out'                   => $this->issuedQty[$issued_key],
                'balance'               => $binCard->balance - $this->issuedQty[$issued_key],
                'date_receipt'          => now(),
                'updated_by'            => auth()->user()->id,
            ]);

            $latestOrder = StoreLedger::where('station_id', $station_id)
                ->where('stock_code_id', $stockCodeID)
                ->orderBy('created_at', 'desc')
                ->first();

                // dd($latestOrder);

            $ledger = StoreLedger::where('station_id', $station_id)
                ->where('stock_code_id', $stockCodeID)
                ->where('purchase_order_id', '!=', $latestOrder->purchase_order_id)
                ->orderBy('created_at', 'desc')
                ->first();

            $previous_order = $latestOrder->qty_balance - $latestOrder->qty_receipt;
            $remaining_qty = $this->issuedQty[$issued_key] - $previous_order;

            // dd($remaining_qty);
            if ($this->issuedQty[$issued_key] !== null && $previous_order == 0){
                // Aggregation
                $value_out = $latestOrder->basic_price * $this->issuedQty[$issued_key];
                $qty_balance = $latestOrder->qty_balance - $this->issuedQty[$issued_key];
                $value_balance = $latestOrder->value_balance - $value_out;

                // New Store Ledger
                storeLedger::create([
                    'purchase_order_id'     => $latestOrder->purchase_order_id,
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'basic_price'           => $latestOrder->basic_price,
                    'station_id'            => $station_id,
                    'qty_issue'             => $this->issuedQty[$issued_key],
                    'qty_balance'           => $qty_balance,
                    'value_out'             => $value_out,
                    'value_balance'         => $value_balance,
                    'unit'                  => $latestOrder->unit,
                    'date'                  => now(),
                    'created_by'            => Auth::user()->id,
                ]);

                IssuingStore::Create([
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'from_station'          => $station_id,
                    'to_station'            => $this->requisitionStore,
                    'quantity'              => $this->issuedQty[$issued_key],
                    'purchase_order_id'     => $latestOrder->purchase_order_id,
                    'issued_by'             => Auth::user()->id,
                    'date'                  => now()
                ]);

                $this->dispatch('success', message: 'Issued Successfully!');
            } else if ($this->issuedQty[$issued_key] <= $previous_order) { 
                // Aggregation
                $value_out = $ledger->basic_price * $this->issuedQty[$issued_key];
                $qty_balance = $ledger->qty_balance - $this->issuedQty[$issued_key];
                $value_balance = $ledger->value_balance - $value_out;

                // dd('Hell0, Available');

                // New Store Ledger
                storeLedger::create([
                    'purchase_order_id'     => $ledger->purchase_order_id,
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'basic_price'           => $ledger->basic_price,
                    'station_id'            => $station_id,
                    'qty_issue'             => $this->issuedQty[$issued_key],
                    'qty_balance'           => $qty_balance,
                    'value_out'             => $value_out,
                    'value_balance'         => $value_balance,
                    'unit'                  => $ledger->unit,
                    'date'                  => now(),
                    'created_by'            => Auth::user()->id,
                ]);

                IssuingStore::Create([
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'from_station'          => $station_id,
                    'to_station'            => $this->requisitionStore,
                    'quantity'              => $this->issuedQty[$issued_key],
                    'purchase_order_id'     => $ledger->purchase_order_id,
                    'issued_by'             => Auth::user()->id,
                    'date'                  => now()
                ]);

                $this->dispatch('success', message: 'Issued Successfully!');
                
            } else if ($this->issuedQty[$issued_key] > $previous_order) {

                // Aggregation
                $value_out = $ledger->basic_price * $previous_order;
                $qty_balance = $latestOrder->qty_balance - $previous_order;
                $value_balance = $latestOrder->value_balance - $value_out;

                $latest_value_out = $latestOrder->basic_price * $remaining_qty;
                $latest_qty_balance = $qty_balance - $remaining_qty;
                $latest_value_balance = $value_balance - $latest_value_out;

                // dd($latest_value_balance);

                // If Available Previous order quantity is greater than Issued quantity then do this
                StoreLedger::create([
                    'purchase_order_id'     => $ledger->purchase_order_id,
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'basic_price'           => $ledger->basic_price,
                    'station_id'            => $station_id,
                    'qty_issue'             => $previous_order,
                    'qty_balance'           => $qty_balance,
                    'value_out'             => $value_out,
                    'value_balance'         => $value_balance,
                    'unit'                  => $ledger->unit,
                    'date'                  => now(),
                    'created_by'            => Auth::user()->id,
                ]);

                IssuingStore::Create([
                    'stock_code_id'         => $stockCodeID,
                    'reference'             => $this->reference,
                    'from_station'          => $station_id,
                    'to_station'            => $this->requisitionStore,
                    'quantity'              => $previous_order,
                    'purchase_order_id'     => $ledger->purchase_order_id,
                    'issued_by'             => Auth::user()->id,
                    'date'                  => now()
                ]);

                if ($remaining_qty > 0) {
                    StoreLedger::create([
                        'purchase_order_id'     => $latestOrder->purchase_order_id,
                        'stock_code_id'         => $stockCodeID,
                        'reference'             => $this->reference,
                        'basic_price'           => $latestOrder->basic_price,
                        'station_id'            => $station_id,
                        'qty_issue'             => $remaining_qty,
                        'qty_balance'           => $latest_qty_balance,
                        'value_out'             => $latest_value_out,
                        'value_balance'         => $latest_value_balance,
                        'unit'                  => $latestOrder->unit,
                        'date'                  => now(),
                        'created_by'            => Auth::user()->id,
                    ]);

                    IssuingStore::Create([
                        'stock_code_id'         => $stockCodeID,
                        'reference'             => $this->reference,
                        'from_station'          => $station_id,
                        'to_station'            => $this->requisitionStore,
                        'quantity'              => $remaining_qty,
                        'purchase_order_id'     => $latestOrder->purchase_order_id,
                        'issued_by'             => Auth::user()->id,
                        'date'                  => now()
                    ]);
                }

                $this->dispatch('success', message: 'Issued Successfully!');

            } else {
                $this->dispatch('danger', message: 'Something Not Right!');
            }
        } else {
                $this->dispatch('danger', message: 'Items Not Found!');
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
        $this->requisitionStore = SRCN::where('srcn_id', $this->srcnID)->pluck('requisitioning_store')->first();
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
        $this->items = Allocation::where('reference', $this->reference)
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
