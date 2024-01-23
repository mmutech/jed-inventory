<?php

namespace App\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\WithPagination;
use App\Models\PurchaseOrders;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Index extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.purchase-order.index')->with([
            'data' => PurchaseOrders::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('purchase_order_no', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
