<?php

namespace App\Livewire\PurchaseOrder;

use App\Models\Approvals;
use App\Models\Item;
use App\Models\PurchaseOrders;
use App\Models\SRA;
use App\Models\StoreBook;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class POBalance extends Component
{
    public $title = 'Balance';

    public $items, $stationID;
    public $sraID, $bal_item, $poNumber, $invoiceNo, $consignmentNo;

    public $confirm_qtys = [], $balance_Qty = [];

    #[Locked]
    public $poID;

    #[Rule('required')]
    public $account_operation_remark_date, $account_operation_remark_by, $account_operation_action, $account_operation_remark_note;

    public function qualityCheck($key, $id, $balance_Qty)
    {
        $items = Item::where('id', $id)->first();

        if (empty($items->balance_check)) {
            $balanceQty = $balance_Qty - $this->confirm_qtys[$key];
            Item::where('id', $id)->first()->update([
                'confirm_bal_qty' => $this->confirm_qtys[$key],
                'balance_qty' => $balanceQty,
                'balance_check' => 1,
                'confirm_bal_by' => Auth::user()->id,
                'confirm_bal_date' => now()
            ]);
    
            $this->confirm_qtys[$key] = ''; 
            $balanceQty = '';
    
            $this->dispatch('success', message: 'Checked and Confirmed!');
        }else{
            $this->dispatch('error', message: 'Already Checked and Confirmed!');
        } 

    }

    public function update()
    {
        $sraDetails = SRA::where('purchase_order_id', $this->poID)
            ->first();

       if ($sraDetails->exists()) {
            $deliveryNote = $sraDetails->delivery_note;
            $invoiceDoc = $sraDetails->invoice_doc;
            $qualityCert = $sraDetails->quality_cert;

            // Create SRA
            SRA::create([
                'sra_id' => $this->sraID,
                'consignment_note_no' => $this->consignmentNo,
                'invoice_no' => $this->invoiceNo,
                'sra_code' => 'SRA-'.$this->sraID,
                'purchase_order_id' => $this->poID,
                'delivery_note' => $deliveryNote,
                'invoice_doc' => $invoiceDoc,
                'quality_cert' => $qualityCert,
                'received_date' => now(),
                'created_by' => Auth::user()->id
            ]);

            $this->dispatch('success', message: 'SRA Created!');
            // return redirect()->to('show-sra/' . $this->poID);

        }else {
            $this->dispatch('info', message: 'SRA Already Exist!');
            // return redirect()->to('show-sra/' . $this->poID);
        }
    }

    public function approved()
    {
        // Get Confirmed Item
        $items = Item::where('purchase_order_id', $this->poID)
        ->where('confirm_bal_qty', '>', 0)->get();
        if($items){
            foreach ($items as $item) {
                if (isset($item->stock_code, $item->purchase_order_id, $item->confirm_bal_qty)) {
                    // Create Store Bin Card
                    $latestStoreBook = StoreBook::where('station_id', $this->stationID)
                        ->where('stock_code_id', $item->stock_code)
                        ->orderBy('created_at', 'desc')
                        ->first();
            
                    $qty_balance = ($latestStoreBook) ? $latestStoreBook->qty_balance : 0;
                    $val_balance = ($latestStoreBook) ? $latestStoreBook->value_balance : 0;
                    $sub_total = $item->confirm_rate;
                    $vat = 7.5;
                    $vat_amount = $sub_total * $vat / 100;
                    $basic_price = $sub_total + $vat_amount;

                    $val_in = $basic_price * $item->confirm_bal_qty;
                    // dd($val_in);
                    StoreBook::create([
                        'purchase_order_id'     => $item->purchase_order_id,
                        'stock_code_id'         => $item->stock_code,
                        'reference'             => 'SRA-'.$this->sraID,
                        'basic_price'           => $basic_price,
                        'station_id'            => $this->stationID,
                        'qty_in'                => $item->confirm_bal_qty,
                        'qty_balance'           => $item->confirm_bal_qty + $qty_balance,
                        'value_in'              => $val_in,
                        'value_balance'         => $val_balance + $val_in,
                        'unit'                  => $item->unit,
                        'date'                  => now(),
                        'created_by'            => Auth::user()->id,
                    ]);

                } else {
                    $this->dispatch('danger', message: 'Items Not Found!');
                }
            }

            // Updated Purchase Order Status
            $qty_bal = Item::where('purchase_order_id', $this->poID)
               ->where('balance_qty', '>', 0)
               ->first();

            $purchaseOrder = PurchaseOrders::where('purchase_order_id', $this->poID)->first();

            if ($purchaseOrder) {
                $status = $qty_bal === null ? 'Completed' : 'Incomplete';
                $purchaseOrder->update([
                    'status' => $status,
                ]);
            }

            //HOAOP Or CFO Approval
            Approvals::create([
                'reference'         => 'SRA-'.$this->sraID,
                'approved_note'     => $this->account_operation_remark_note,
                'approved_action'   => $this->account_operation_action,
                'approved_by'       => auth()->user()->id,
                'approved_date'     => now()
            ]);
            
            $this->dispatch('success', message: 'SRA Approved By Account Operation!');
            return redirect()->to('show-sra/' . $this->poID);
        }else{
            $this->dispatch('danger', message: 'JOB ORDER NOT FOUND!');
        } 
    }

    public function mount($poID)
    {
        $this->poID = $poID;

        $this->stationID = PurchaseOrders::where('purchase_order_id', $this->poID)->pluck('delivery_address')->first();
        $this->items = Item::where('purchase_order_id', $this->poID)
        ->where('balance_qty', '>', 0)
        ->get();

         // Store Received Advice ID
         $lastRecord = SRA::latest()->first();
         $this->sraID = $lastRecord ? $lastRecord->sra_id + 1 : 1;
 
         $this->poNumber = PurchaseOrders::where('purchase_order_id', $this->poID)
         ->pluck('purchase_order_no')->first();
 
         $sraDetails = SRA::where('purchase_order_id', $this->poID)
         ->first();
 
         $this->invoiceNo = $sraDetails->invoice_no;
         $this->consignmentNo = $sraDetails->consignment_note_no;
 
         // Get Confirmed Item
         $this->bal_item = Item::where('purchase_order_id', $this->poID)
         ->where('confirm_bal_qty', '>', 0)->get();

        //  dd($this->bal_item);
    }

    public function render()
    {
        return view('livewire.purchase-order.p-o-balance');
    }
}
