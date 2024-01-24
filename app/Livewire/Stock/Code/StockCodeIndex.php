<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockCode;

class StockCodeIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {   
        return view('livewire.stock.code.stock-code-index')->with([
            'data' => StockCode::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
