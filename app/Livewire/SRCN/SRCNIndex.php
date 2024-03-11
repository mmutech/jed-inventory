<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use App\Models\SRCN;
use App\Models\Store;
use Livewire\WithPagination;

class SRCNIndex extends Component
{
    public $search = '', $storeID;
    
    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // dd($this->createdBy);
    }

    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-index')->with([
            'data' => SRCN::latest()->where(function ($filter){
                $filter->where('srcn_code', 'like', '%'.$this->search.'%');
            })->paginate(5),
        ]);
    }
}
