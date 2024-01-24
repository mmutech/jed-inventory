<?php

namespace App\Livewire\Stock\Class;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCategory;
use App\Models\StockClass;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockClassEdit extends Component
{
    public $title = 'Modify Stock Category';

    public $stockClassID;

    #[Locked]
    public $stClassID;

    #[Rule('required')]
    public $name, $status, $stock_category_id;

    public function update()
    {
        $this->validate();

        // Modify Stock Class
        if (StockClass::where('id', $this->stClassID)->exists()) {
            StockClass::where('id', $this->stClassID)->first()->update([
                'name' => $this->name,
                'stock_category_id' => $this->stock_category_id,
                'status' => $this->status,
                'updated_by' => Auth::user()->id

            ]); 

            $this->dispatch('info', message: 'Stock Class Updated!');

            return redirect()->to('/stock-class-index');

        }else {
            $this->dispatch('info', message: 'Stock Class Already Exist!');
        }
    }

    public function mount($stClassID)
    {
        $this->stClassID = $stClassID;

        // Edit
        $data = StockClass::where('id', $this->stClassID)->get();
        if ($data->count() > 0) {

            foreach ($data as $StockClass) {
                $this->stockClassID = $StockClass->id;
                $this->name = $StockClass->name;
                $this->stock_category_id = $StockClass->stock_category_id;
                $this->status = $StockClass->status;
            }
        } else {
            $this->dispatch('info', message: 'Stock Class Not Exist!');
            return redirect()->to('/Stock-class-index');
        }

    }

    public function render()
    {
        return view('livewire.stock.class.stock-class-edit')->with([
            'stock_category' => StockCategory::where('status', 'Active')->latest()->get()
        ]);
    }
}
