<?php

namespace App\Livewire\Stock\Category;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCategory;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockCategoryCreate extends Component
{
    public $title = 'Create Stock Category';

    #[Locked]
    public $stID;

    #[Rule('required')]
    public $name;

    public function store()
    {
        $this->validate();

        // Create Store

        if (!StockCategory::where('name', $this->name)->exists()) {
            StockCategory::create([
                'name' => $this->name,
                'status' => 'Active',
                'created_by' => Auth::user()->id

            ]); 

            $this->dispatch('success', message: 'Stock Category Created!');

            return redirect()->to('/stock-category-index');

        }else {
            $this->dispatch('info', message: 'Stock Category Already Exist!');
        }
    }

    public function render()
    {
        return view('livewire.stock.category.stock-category-create');
    }
}
