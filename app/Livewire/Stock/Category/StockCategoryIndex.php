<?php

namespace App\Livewire\Stock\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockCategory;

class StockCategoryIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.stock.category.stock-category-index')->with([
            'data' => StockCategory::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
