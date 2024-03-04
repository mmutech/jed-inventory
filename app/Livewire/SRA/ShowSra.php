<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use App\Models\StoreBinCard;
use App\Models\SRA;
use App\Models\PurchaseOrders;
use App\Models\Item;
use App\Models\QualityChecks;
use App\Models\StoreLedger;
use App\Models\Approvals;
use Illuminate\Support\Facades\Auth;

class ShowSra extends Component
{
    public $title = 'New SRA';
    public $items, $reference, $sraCode, $stationID;

    #[Rule('required')]
    public $account_operation_remark_date, $account_operation_remark_by, $account_operation_action, $account_operation_remark_note;

    #[Locked]
    public $poID;

    public function approved()
    {
        // Validation
        // $this->validate();

        // Remark by Account Operations
            if($this->poID){
                Approvals::create([
                    'reference'         => $this->reference,
                    'approved_note'     => $this->account_operation_remark_note,
                    'approved_action'   => $this->account_operation_action,
                    'approved_by'       => auth()->user()->id,
                    'approved_date'     => now()
                ]);
            }

            // Updated Purchase Order Status
            PurchaseOrders::where('purchase_order_id', $this->poID)->first()->update([
                'status' => 'Completed',
            ]);

            // Create Store Bin Card
            foreach ($this->items as $item) {
                if (isset($item->stock_code, $item->purchase_order_id, $item->confirm_qty)) {
            
                    $latestBinCard = StoreBinCard::where('station_id', $this->stationID)
                        ->where('stock_code_id', $item->stock_code)
                        ->orderBy('created_at', 'desc')
                        ->first();
            
                    $balance = ($latestBinCard) ? $latestBinCard->balance : 0;
                    
                    StoreBinCard::create([
                        'stock_code_id'     => $item->stock_code,
                        'reference'         => $this->reference,
                        'purchase_order_id' => $item->purchase_order_id,
                        'station_id'        => $this->stationID,
                        'in'                => $item->confirm_qty,
                        'balance'           => $item->confirm_qty + $balance,
                        'unit'              => $item->unit,
                        'date_receipt'      => now(),
                        'created_by'        => auth()->user()->id,
                    ]);
                } else {

                }
            }

            // Create Store Ledger
            foreach ($this->items as $item) {
                if (isset($item->stock_code, $item->purchase_order_id, $item->confirm_qty)) {
                    $latestStoreLedger = StoreLedger::where('station_id', $this->stationID)
                        ->where('stock_code_id', $item->stock_code)
                        ->orderBy('created_at', 'desc')
                        ->first();
            
                    $qty_balance = ($latestStoreLedger) ? $latestStoreLedger->qty_balance : 0;

                    StoreLedger::create([
                        'stock_code_id'         => $item->stock_code,
                        'reference'             => $this->reference,
                        'basic_price'           => $item->confirm_rate,
                        'station_id'            => $this->stationID,
                        'qty_receipt'           => $item->confirm_qty,
                        'qty_balance'           => $item->confirm_qty + $qty_balance,
                        'value_in'              => $item->confirm_rate * $item->confirm_qty,
                        'value_balance'         => $item->confirm_rate * $item->confirm_qty,
                        'unit'                  => $item->unit,
                        'date'                  => now(),
                        'created_by'            => Auth::user()->id,
                    ]);
                } else {

                }
            }

            $this->dispatch('info', message: 'SRA Approved By Account Operation!');
    }

    public function mount($poID)
    {
        $this->poID = $poID;
        $this->items = Item::where('purchase_order_id', $this->poID)->get();
        $this->reference = SRA::where('purchase_order_id', $this->poID)->pluck('sra_code')->first();
        $this->stationID = PurchaseOrders::where('purchase_order_id', $this->poID)->pluck('delivery_address')->first();
        // dd($this->poID);
    }

    public function render()
    {
        return view('livewire.s-r-a.show-sra')->with([
            'data' => SRA::where('purchase_order_id', $this->poID)->first(),
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
            'approval' => Approvals::where('reference', $this->reference)->first(),
            'qualityCheck' => QualityChecks::where('reference', $this->poID)->first(),
        ]);
    }
}
