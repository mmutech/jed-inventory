<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCode;
use App\Models\StockCategory;
use App\Models\StockClass;
use Illuminate\Support\Facades\Auth;

class StockCodeCreate extends Component
{
    public $title = 'Create Stock Code';
    
    #[Rule('required')]
    public $name, $SelectedStockCategory, $stockClass, $stock_class_id = null, $stock_code;

    public function store()
    {
        $this->validate();

        // Create Stock Code

        if (!StockCode::where('stock_code', $this->stock_code)->exists()) {
            StockCode::create([
                'stock_code' => $this->stock_code,
                'name' => $this->name,
                'stock_category_id' => $this->SelectedStockCategory,
                'stock_class_id' => $this->stock_class_id,
                'status' => 'Active',
                'created_by' => Auth::user()->id

            ]); 

            $this->dispatch('success', message: 'Stock Code Created!');

            return redirect()->to('/stock-code-index');

        }else {
            $this->dispatch('info', message: 'Stock Code Already Exist!');
        }
    }

    public function render()
    {
        // $this->stockClass = StockClass::where('stock_category_id', $stockCategoryID)->get();

        // $this->stockClass = StockClass::where('status', 'Active')->latest()->get();

        // dd($this->stockClass);
        
        return view('livewire.stock.code.stock-code-create')->with([
            'stock_category' => StockCategory::where('status', 'Active')->latest()->get(),
        ]);
    }

    public function updatedSelectedCategory($stock_category_id)
    {
        $this->stockClass = StockClass::where('stock_category_id', $stock_category_id)->get();
        // dd($this->stockClass);
    }
}
