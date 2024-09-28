<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use App\Models\QualityChecks;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class QualityCheck extends Component
{
    public $title = 'Quality Check';

    public $item;

    public $confirm_qtys = [], $confirm_rates = [], $quantity = [];

    #[Rule('required')]
    public $quality_check_note, $quality_check_action;

    #[Locked]
    public $poID;

    public function qualityCheck($key, $id, $quantity)
    {
        $items = Item::where('id', $id)->first();

        if (empty($items->quality_check)) {
            $balanceQty = $quantity - $this->confirm_qtys[$key];
            Item::where('id', $id)->first()->update([
                'confirm_qty' => $this->confirm_qtys[$key],
                'balance_qty' => $balanceQty,
                'confirm_rate' => $this->confirm_rates[$key],
                'quality_check' => 1,
                'confirm_by' => Auth::user()->id,
                'confirm_date' => now()
            ]);
    
            $this->confirm_qtys[$key] = ''; 
            $this->confirm_rates[$key] = ''; 
            $balanceQty = '';
    
            $this->dispatch('success', message: 'Checked and Confirmed!');
        }else{
            $this->dispatch('error', message: 'Already Checked and Confirmed!');
        } 

    }

    public function qualityCheckRemark()
    {    
        // Quality Check Remark
        QualityChecks::create([
            'reference' => $this->poID,
            'quality_check_note' => $this->quality_check_note,
            'quality_check_date' => now(),
            'quality_check_by' => Auth::user()->id
        ]);

        $this->dispatch('info', message: 'Quality Checks Completed!');
        return redirect()->to('purchase-order-show/' . $this->poID);

    }

    public function mount($poID)
    {
        $this->poID = $poID;

        // dd($approved);
    }

    public function render()
    {
        return view('livewire.purchase-order.quality-check')->with([
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
