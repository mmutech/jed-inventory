<?php

namespace App\Livewire\QualityCheck;

use Livewire\Component;
use App\Models\PurchaseOrders;

class QualityCheckIndex extends Component
{
    public $search = '';

    public function render()
    {
        $query = PurchaseOrders::where('status', 'Approved')->latest()
        ->where(function ($filter){
                $filter->where('status', 'like', '%'.$this->search.'%')
                    ->orWhere('purchase_order_no', 'like', '%'.$this->search.'%');
        });

        return view('livewire.quality-check.quality-check-index')->with([
            'data' => $query->paginate(10),
        ]);
    }
}
