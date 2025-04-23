<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use App\Models\PurchaseOrders;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CreateSra extends Component
{
    public $storeID, $search = '';

    public function render()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $query = PurchaseOrders::where('status', 'Checked')->latest()
        ->where(function ($filter){
                $filter->where('status', 'like', '%'.$this->search.'%')
                    ->orWhere('purchase_order_no', 'like', '%'.$this->search.'%');
        });

        if (auth()->user()->hasRole('Store-Officer')) {
            $query->where('delivery_address', $this->storeID);
        }

        return view('livewire.s-r-a.create-sra')->with([
            'data' => $query->paginate(10),
        ]);
    }
}
