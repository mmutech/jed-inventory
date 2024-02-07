<?php

namespace App\Livewire\SRCN;

use Livewire\Component;
use App\Models\SRCN;
use Livewire\WithPagination;

class SRCNIndex extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.s-r-c-n.s-r-c-n-index')->with([
            'data' => SRCN::latest()->where(function ($filter){
                $filter->where('srcn_code', 'like', '%'.$this->search.'%');
            })->paginate(5),
        ]);
    }
}
