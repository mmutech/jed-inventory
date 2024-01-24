<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCode;
use App\Models\StockCategory;
use App\Models\StockClass;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockCodeEdit extends Component
{
    public $title = 'Modify Stock Code';

    #[Locked]
    public $stCodeID;

    #[Rule('required')]
    public $name, $stock_category_id, $stock_class_id, $stock_code, $stockCodeID, $status;

    public function update()
    {
        $this->validate();

        // Modify Stock Code
        if (StockCode::where('id', $this->stCodeID)->exists()) {
            StockCode::where('id', $this->stCodeID)->first()->update([
                'stock_code' => $this->stock_code,
                'name' => $this->name,
                'stock_category_id' => $this->stock_category_id,
                'stock_class_id' => $this->stock_class_id,
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

        // Edit
        $data = StockCode::where('id', $this->stCodeID)->get();
        if ($data->count() > 0) {

            foreach ($data as $StockCode) {
                $this->stockCodeID = $StockCode->id;
                $this->stock_code = $StockCode->stock_code;
                $this->name = $StockCode->name;
                $this->stock_category_id = $StockCode->stock_category_id;
                $this->stock_class_id = $StockCode->stock_class_id;
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
            'stock_category' => StockCategory::where('status', 'Active')->latest()->get(),
            'stock_class' => StockClass::where('status', 'Active')->latest()->get()
        ]);
    }
}
