<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Store;

class StoreIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.store.store-index')->with([
            'data' => store::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('location', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
