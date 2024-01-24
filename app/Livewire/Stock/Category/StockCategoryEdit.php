<?php

namespace App\Livewire\Stock\Category;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\StockCategory;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StockCategoryEdit extends Component
{
    public $title = 'Modify Stock Category';

    public $stockCategoryID;

    #[Locked]
    public $stCategoryID;

    #[Rule('required')]
    public $name, $status;

    public function update()
    {
        $this->validate();

        // Modify Stock
        if (StockCategory::where('id', $this->stCategoryID)->exists()) {
            StockCategory::where('id', $this->stCategoryID)->first()->update([
                'name' => $this->name,
                'status' => $this->status,
                'updated_by' => Auth::user()->id

            ]); 

            $this->dispatch('info', message: 'Stock Category Updated!');

            return redirect()->to('/stock-category-index');

        }else {
            $this->dispatch('info', message: 'Stock Category Already Exist!');
        }
    }

    public function mount($stCategoryID)
    {
        $this->stCategoryID = $stCategoryID;

        // Edit
        $data = StockCategory::where('id', $this->stCategoryID)->get();
        if ($data->count() > 0) {

            foreach ($data as $StockCategory) {
                $this->stockCategoryID = $StockCategory->id;
                $this->name = $StockCategory->name;
                $this->status = $StockCategory->status;
            }
        } else {
            $this->dispatch('info', message: 'Stock Category Not Exist!');
            return redirect()->to('/Stock-category-index');
        }

    }

    public function render()
    {
        return view('livewire.stock.category.stock-category-edit');
    }
}
