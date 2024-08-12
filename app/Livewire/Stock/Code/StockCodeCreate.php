<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCode;
use App\Models\StockCategory;
use App\Models\StockClass;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class StockCodeCreate extends Component
{
    public $title = 'Create Stock Code';
    
    #[Rule('required')]
    public $name, $unit, $selectedStockCategory, $selectedStockClass, $stock_category, $stock_class = null, $stock_code;

    public function store()
    {
        $this->validate();

        // Create Stock Code
        if (!StockCode::where('stock_code', $this->stock_code)->exists()) {
            if ($this->stock_code) {            
            
                // Save the data, to the database
                $stockCode = new StockCode();
                $stockCode->stock_code = $this->stock_code;
                $stockCode->name = $this->name;
                $stockCode->stock_category_id = $this->selectedStockCategory;
                $stockCode->stock_class_id = $this->selectedStockClass;
                $stockCode->unit = $this->unit;
                $stockCode->status = 'Active';
                $stockCode->created_by = Auth::user()->id;
                $stockCode->save();
            }
            
            // StockCode::create([
            //     'stock_code' => $this->stock_code,
            //     'name' => $this->name,
            //     'stock_category_id' => $this->selectedStockCategory,
            //     'stock_class_id' => $this->selectedClass,
            //     'barcode' => $barcodeHtml,
            //     'status' => 'Active',
            //     'created_by' => Auth::user()->id
            // ]); 

            $this->dispatch('success', message: 'Stock Code Created!');

            return redirect()->to('/stock-code-index');

        }else {
            $this->dispatch('info', message: 'Stock Code Already Exist!');
        }
    }

    public function mount()
    {
        $this->stock_category   = StockCategory::get();
        $this->stock_class       = collect();

    }

    public function render()
    {        
        return view('livewire.stock.code.stock-code-create')->with([
            'unitOfMeasure' => Unit::latest()->get()
        ]);
    }

    public function updatedSelectedStockCategory($stock_category)
    {
        $this->stock_class = StockClass::where('stock_category_id', $stock_category)->get();
    }
}
