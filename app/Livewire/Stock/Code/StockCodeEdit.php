<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCode;
use App\Models\StockCategory;
use App\Models\StockClass;
use App\Models\Unit;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockCodeEdit extends Component
{
    public $title = 'Modify Stock Code';

    #[Locked]
    public $stCodeID;

    public $stock_category, $stock_class;

    public $name, $selectedStockCategory, $selectedStockClass, $stock_code, $stockCodeID, $status, $unit;

    public function update()
    {
        // Modify Stock Code
        if (StockCode::where('id', $this->stCodeID)->exists()) {
            StockCode::where('id', $this->stCodeID)->first()->update([
                'stock_code' => $this->stock_code,
                'name' => $this->name,
                'unit' => $this->unit,
                'stock_category_id' => $this->selectedStockCategory,
                'stock_class_id' => $this->selectedStockClass,
                'status' => $this->status,
                'updated_by' => Auth::user()->id

            ]); 

            $this->dispatch('info', message: 'Stock Code Updated!');

            return redirect()->to('/stock-code-index');

        }else {
            $this->dispatch('info', message: 'Stock Code Already Exist!');
        }
    }

    public function mount($stCodeID)
    {
        $this->stCodeID = $stCodeID;

        $this->stock_category   = StockCategory::get();
        $this->stock_class       = collect();

        // Edit
        $data = StockCode::where('id', $this->stCodeID)->get();
        if ($data->count() > 0) {

            foreach ($data as $StockCode) {
                $this->stockCodeID = $StockCode->id;
                $this->stock_code = $StockCode->stock_code;
                $this->name = $StockCode->name;
                $this->unit = $StockCode->unit;
                $this->selectedStockCategory = $StockCode->stock_category_id;
                $this->selectedStockClass = $StockCode->stock_class_id;
                $this->status = $StockCode->status;
            }
        } else {
            $this->dispatch('info', message: 'Stock Code Not Exist!');
            return redirect()->to('/Stock-code-index');
        }

    }

    public function render()
    {
        return view('livewire.stock.code.stock-code-edit')->with([
            'unitOfMeasure' => Unit::latest()->get()
        ]);
    }

    public function updatedSelectedStockCategory($stock_category)
    {
        $this->stock_class = StockClass::where('stock_category_id', $stock_category)->get();
    }
}
