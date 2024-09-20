<?php

namespace App\Livewire\Stock\Class;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockClass;

class StockClassIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.stock.class.stock-class-index')->with([
            'data' => StockClass::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->get(),
        ]);
    }
}
