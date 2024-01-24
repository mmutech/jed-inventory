<?php

namespace App\Livewire\Stock\Class;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCategory;
use App\Models\StockClass;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockClassCreate extends Component
{
    public $title = 'Create Stock Class';

    #[Locked]
    public $stID;

    #[Rule('required')]
    public $name, $stock_category_id;

    public function store()
    {
        $this->validate();

        // Create Stock Class

        if (!StockClass::where('name', $this->name)->exists()) {
            StockClass::create([
                'name' => $this->name,
                'stock_category_id' => $this->stock_category_id,
                'status' => 'Active',
                'created_by' => Auth::user()->id

            ]); 

            $this->dispatch('success', message: 'Stock Class Created!');

            return redirect()->to('/stock-class-index');

        }else {
            $this->dispatch('info', message: 'Stock Class Already Exist!');
        }
    }

    public function render()
    {
        return view('livewire.stock.class.stock-class-create')->with([
            'stock_category' => StockCategory::where('status', 'Active')->latest()->get()
        ]);
    }
}
