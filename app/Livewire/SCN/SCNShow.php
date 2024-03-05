<?php

namespace App\Livewire\SCN;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\SCN;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\Unit;
use App\Models\location;
use App\Models\Received;
use App\Models\StoreBinCard;
use App\Models\StoreLedger;
use Illuminate\Support\Facades\Auth;

class SCNShow extends Component
{
    public $title = 'SCN Details';

    public $received_note, $storeID, $location, $scnID, $reference, $items, $stockCodeIDs;

     //Received
     public function received()
     {
        //  dd($this->items);
         if (!empty($this->items)) {

            foreach ($this->items as $item) {
                $latestBinCard = StoreBinCard::where('station_id', $this->storeID)
                    ->where('stock_code_id', $item->stock_code_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
        
                $balance = ($latestBinCard) ? $latestBinCard->balance : 0;

                StoreBinCard::create([
                    'stock_code_id' => $item->stock_code_id,
                    'unit'          => $item->unit,
                    'reference'     => $this->reference,
                    'station_id'    => $this->storeID,
                    'in'            => $item->quantity,
                    'balance'       => $item->quantity + $balance,
                    'date_receipt'  => now(),
                ]);
            }

            foreach ($this->items as $item) {
                SCN::where('scn_id', $item->scn_id)->update([
                    'scn_id'             => $item->scn_id,
                    'station_id'         => $this->storeID,
                    'returned_date'      => now(),
                    'received_by'        => auth()->user()->id
                ]);
            }

            // Create Store Ledger
             foreach ($this->items as $item) {
                if (isset($item->stock_code_id)) {
                    $latestStoreLedger = StoreLedger::where('station_id', $this->storeID)
                        ->where('stock_code_id', $item->stock_code_id)
                        ->orderBy('created_at', 'desc')
                        ->first();
            
                    $qty_balance = ($latestStoreLedger) ? $latestStoreLedger->qty_balance : 0;
                    $basic_price = $latestStoreLedger->basic_price;
                    $value_in = $basic_price * $item->quantity;

                    StoreLedger::create([
                        'stock_code_id'         => $item->stock_code_id,
                        'reference'             => $this->reference,
                        'basic_price'           => $basic_price,
                        'station_id'            => $this->storeID,
                        'qty_receipt'           => $item->quantity,
                        'qty_balance'           => $item->quantity + $qty_balance,
                        'value_in'              => $basic_price * $item->quantity,
                        'value_balance'         => $value_in + $latestStoreLedger->value_balance,
                        'unit'                  => $item->unit,
                        'date'                  => now(),
                        'created_by'            => Auth::user()->id,
                    ]);
                } else {

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

    public function mount($scnID)
    {
        $this->scnID = $scnID;
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->reference = SCN::where('scn_id', $this->scnID)->pluck('scn_code')->first();
        $this->items = SCN::where('scn_id', $this->scnID)->get();
        $this->stockCodeIDs = SCN::where('scn_id', $this->scnID)->pluck('stock_code_id'); 
        
        // dd($this->items);
    }

    public function render()
    {
        return view('livewire.s-c-n.s-c-n-show')->with([
            'data'              => SCN::where('scn_id', $this->scnID)->first(),
            'received'          => Received::where('reference', $this->reference)->first(),
        ]);
    }
}
