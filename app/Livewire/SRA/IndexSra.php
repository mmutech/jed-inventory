<?php

namespace App\Livewire\SRA;

use App\Models\PurchaseOrders;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SRA;
use App\Models\Store;

class IndexSra extends Component
{
    public $storeID, $poIDs, $search = '';

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->poIDs = PurchaseOrders::where('delivery_address', $this->storeID)->pluck('id');

        // dd($this->poIDs);
    }

    public function render()
    {
        $query = SRA::latest()->where(function ($filter) {
            $filter->where('sra_code', 'like', '%' . $this->search . '%')
                ->orWhere('invoice_no', 'like', '%' . $this->search . '%')
                ->orWhere('consignment_note_no', 'like', '%' . $this->search . '%');
        });

        if (auth()->user()->hasRole('Store-Officer')) {
            $query->whereIn('purchase_order_id', $this->poIDs);
        }

        return view('livewire.s-r-a.index-sra')->with([
            'data' => $query->paginate(5),
        ]);
    }
}
