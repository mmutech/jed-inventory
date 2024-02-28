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
                StoreBinCard::create([
                    'stock_code_id' => $item->stock_code_id,
                    'unit'          => $item->unit,
                    'reference'     => $this->reference,
                    'station_id'    => $this->storeID,
                    'in'            => $item->quantity,
                    'balance'       => $item->quantity,
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
