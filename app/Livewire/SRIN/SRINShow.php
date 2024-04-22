<?php

namespace App\Livewire\SRIN;

use App\Models\Allocation;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Models\Despatched;
use App\Models\FAAprroval;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\Item;
use App\Models\Received;
use App\Models\SRIN;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\StoreLedger;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class SRINShow extends Component
{
    public $title = 'SRIN Details';

    #[Locked]
    public $srinID;

    public $recommend_action, $recommend_note, $fa_approved_action, $fa_approved_note, $issuingStore,
    $despatched_note, $received_note, $storeID, $location, $stockCodeIDs, $requisitionStore, 
    $issuedStoreID, $items, $reference, $createdBy;

    //FA Approval
    public function faApproval()
    {
        if($this->srinID){
            FAAprroval::create([
                'reference'         => $this->reference,
                'fa_approved_note'    => $this->fa_approved_note,
                'fa_approved_action'  => $this->fa_approved_action,
                'fa_approved_by'      => auth()->user()->id,
                'fa_approved_date'    => now()
            ]);

            $this->dispatch('success', message: 'FA Approval!');
        }
        
    }

    //Received
    public function received()
    {
        $issuedStores = IssuingStore::where('reference', $this->reference)
            ->where('to_station', $this->storeID)
            ->whereIn('stock_code_id', $this->stockCodeIDs)
            ->groupBy('stock_code_id', 'purchase_order_id')
            ->select('stock_code_id', 'purchase_order_id', DB::raw('sum(quantity) as total_quantity'))
            ->get();

        // dd($issuedStores);
        if (!empty($issuedStores)) {
            foreach ($issuedStores as $issuedStore) {
                $latestBinCard = StoreBinCard::where('station_id', $this->storeID)
                    ->where('stock_code_id', $issuedStore->stock_code_id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $item = Item::where('purchase_order_id', $issuedStore->purchase_order_id)
                    ->where('stock_code', $issuedStore->stock_code_id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $ledger = StoreLedger::where('station_id', $this->storeID)
                    ->where('stock_code_id', $issuedStore->stock_code_id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                // Create Store Bin Card
                $balance = ($latestBinCard) ? $latestBinCard->balance : 0;
                
                StoreBinCard::create([
                    'purchase_order_id' => $issuedStore->purchase_order_id,
                    'stock_code_id'     => $issuedStore->stock_code_id,
                    'unit'              => $item->unit,
                    'reference'         => $this->reference,
                    'station_id'        => $this->requisitionStore,
                    'in'                => $issuedStore->total_quantity,
                    'balance'           => $issuedStore->total_quantity + $balance,
                    'date_receipt'      => now(),
                ]);

                // Create Store Ledger
                $qty_balance = ($ledger) ? $ledger->qty_balance : 0;
                $value_balance = ($ledger) ? $ledger->value_balance : 0;

                // Vat Calculations
                $sub_total = $item->confirm_rate;
                $vat = 7.5;
                $vat_amount = $sub_total * $vat / 100;
                $basic_price = $sub_total + $vat_amount;
                $value_in = $basic_price * $issuedStore->total_quantity;

                StoreLedger::create([
                    'purchase_order_id'     => $issuedStore->purchase_order_id,
                    'stock_code_id'         => $issuedStore->stock_code_id,
                    'reference'             => $this->reference,
                    'basic_price'           => $basic_price,
                    'station_id'            => $this->storeID,
                    'qty_receipt'           => $issuedStore->total_quantity,
                    'qty_balance'           => $qty_balance + $issuedStore->total_quantity,
                    'value_in'              => $value_in,
                    'value_balance'         => $value_balance + $value_in,
                    'unit'                  => $item->unit,
                    'date'                  => now(),
                    'created_by'            => Auth::user()->id,
                ]);
               
            }

            Received::create([
                'reference'        => $this->reference,
                'received_note'    => $this->received_note,
                'received_by'      => auth()->user()->id,
                'received_date'    => now()
            ]);

            $this->dispatch('success', message: 'Item Received Successfully!');
        }
    }

    public function mount($srinID)
    {
        $this->srinID = $srinID;
        $this->requisitionStore = SRIN::where('srin_id', $this->srinID)->pluck('location')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRIN::where('srin_id', $this->srinID)->pluck('srin_code')->first();
        $this->items = SRIN::where('srin_id', $this->srinID)->get();
        $this->issuedStoreID = Allocation::where('reference', $this->reference)->pluck('station_id')->first();
        $this->stockCodeIDs = SRIN::where('srin_id', $this->srinID)->pluck('stock_code_id'); 
        $this->createdBy = SRIN::where('srin_id', $this->srinID)->pluck('created_by')->first();
        // dd($this->srinID);
    }

    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-show')->with([
            'data'              => SRIN::where('srin_id', $this->srinID)->first(),
            'fa_approval'       => FAAprroval::where('reference', $this->reference)->first(),
            'hod_approval'      => HODApproval::where('reference', $this->reference)->first(),
            'despatched'        => Despatched::where('reference', $this->reference)->first(),
            'received'          => Received::where('reference', $this->reference)->first(),
            'issuingStores'     => IssuingStore::where('reference', $this->reference)->get(),
            'vehicle'           => Vehicle::where('reference', $this->reference)->get(),
        ]);
    }
}
