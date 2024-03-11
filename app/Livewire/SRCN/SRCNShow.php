<?php

namespace App\Livewire\SRCN;

use App\Models\Approvals;
use App\Models\Despatched;
use App\Models\HODApproval;
use App\Models\IssuingStore;
use App\Models\Received;
use App\Models\Recommendations;
use Livewire\Component;
use App\Models\SRCN;
use App\Models\SRCNItem;
use App\Models\Store;
use App\Models\StoreBinCard;
use App\Models\StoreLedger;
use App\Models\Vehicle;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SRCNShow extends Component
{
    public $title = 'SRCN Details';

    #[Locked]
    public $srcnID;

    public $recommend_action, $recommend_note, $approved_action, $approved_note,
    $storeID, $requisitionStore, $received_note, $createdBy;

    public $items, $reference, $stockCodeIDs, $issuingStore, $issuedStore, $issuedStoreID;

    //Recommendation
    public function recommend()
    {
        if($this->srcnID){
            Recommendations::create([
                'reference'         => $this->reference,
                'recommend_note'    => $this->recommend_note,
                'recommend_action'  => $this->recommend_action,
                'recommend_by'      => auth()->user()->id,
                'recommend_date'    => now()
            ]);

            $this->dispatch('success', message: 'Recommend!');
        }
        
    }

    //HOD Approval
    public function haopApproval()
    {
        if($this->srcnID){
            Approvals::create([
                'reference'         => $this->reference,
                'approved_note'    => $this->approved_note,
                'approved_action'  => $this->approved_action,
                'approved_by'      => auth()->user()->id,
                'approved_date'    => now()
            ]);

            $this->dispatch('success', message: 'HAOP Approval!');
        }
        
    }

    //Received
    public function received()
    {
        $issuedStore = IssuingStore::where('reference', $this->reference)
        ->whereIn('stock_code_id', $this->stockCodeIDs)
        ->groupBy('stock_code_id')
        ->select('stock_code_id', DB::raw('sum(quantity) as total_quantity'))
        ->get();

        // dd($issuedStore);
        if (!empty($issuedStore)) {
            foreach ($issuedStore as $issuedStores) {
                $latestBinCard = StoreBinCard::where('station_id', $this->storeID)
                    ->where('stock_code_id', $issuedStores->stock_code_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
        
                $balance = ($latestBinCard) ? $latestBinCard->balance : 0;
                
                // StoreBinCard::create([
                //     'stock_code_id' => $issuedStores->stock_code_id,
                //     'reference'     => $this->reference,
                //     'station_id'    => $this->requisitionStore,
                //     'in'            => $issuedStores->total_quantity,
                //     'balance'       => $issuedStores->total_quantity + $balance,
                //     'date_receipt'  => now(),
                // ]);
            }

            // Create Store Ledger
            $items = StoreLedger::where('reference', $this->reference)->get();

            //  dd($items);
            foreach ($items as $item) {
                if (isset($item->stock_code_id, $item->basic_price)) {
                    $latestStoreLedger = StoreLedger::where('station_id', $this->storeID)
                        ->where('stock_code_id', $item->stock_code_id)
                        ->orderBy('created_at', 'desc')
                        ->first();
            
                    $qty_balance = ($latestStoreLedger) ? $latestStoreLedger->qty_balance : 0;
                    $value_in = $item->basic_price * $item->qty_issue;
                    StoreLedger::create([
                        'purchase_order_id'     => $item->purchase_order_id,
                        'stock_code_id'         => $item->stock_code_id,
                        'reference'             => $this->reference,
                        'basic_price'           => $item->basic_price,
                        'station_id'            => $this->storeID,
                        'qty_receipt'           => $item->qty_issue,
                        'qty_balance'           => $item->qty_issue + $qty_balance,
                        'value_in'              => $value_in,
                        'value_balance'         => $latestStoreLedger->value_balance + $value_in,
                        'unit'                  => $item->unit,
                        'date'                  => now(),
                        'created_by'            => Auth::user()->id,
                    ]);
                } 
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

    public function mount($srcnID)
    {
        $this->srcnID = $srcnID;
        $this->requisitionStore = SRCN::where('srcn_id', $this->srcnID)->pluck('requisitioning_store')->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SRCN::where('srcn_id', $this->srcnID)->pluck('srcn_code')->first();
        $this->items = SRCNItem::where('srcn_id', $this->srcnID)->get();
        $this->issuedStoreID = IssuingStore::where('reference', $this->reference)->pluck('station_id')->first();
        $this->stockCodeIDs = SRCNItem::where('srcn_id', $this->srcnID)->pluck('stock_code_id'); 
        $this->createdBy = SRCN::where('srcn_id', $this->srcnID)->pluck('created_by')->first();

        // dd($this->createdBy);
    }
    
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-show')->with([
            'data'             => SRCN::where('srcn_id', $this->srcnID)->first(),
            'approval'         => Approvals::where('reference', $this->reference)->first(),
            'hod_approval'     => HODApproval::where('reference', $this->reference)->first(),
            'recommend'        => Recommendations::where('reference', $this->reference)->first(),
            'despatch'         => Despatched::where('reference', $this->reference)->first(),
            'received'         => Received::where('reference', $this->reference)->first(),
            'vehicle'          => Vehicle::where('reference', $this->reference)->get(),
            'issued_store'     => IssuingStore::where('reference', $this->reference)->first(),
        ]);
    }
}
