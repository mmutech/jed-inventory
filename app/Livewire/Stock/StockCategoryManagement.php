<?php

namespace App\Livewire\Stock;

use App\Models\StockCategory;
use App\Models\StockClass;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class StockCategoryManagement extends Component
{
    use WithPagination;

    #[Rule('required|unique:stock_categories,name')]
    public $name;

    #[Rule('required')]
    public $stock_class_id;

    public $categoryID, $status, $search = '';
    public $isEditing = false;

    // Create Stock Category
    public function store()
    {
        $this->validate();

        if (!StockCategory::where('name', $this->name)->exists()) {
            StockCategory::create([
                'name'              => $this->name,
                'stock_class_id'    => $this->stock_class_id,
                'status'            => 'Active',
                'created_by'        => Auth::user()->id

            ]);

            $this->dispatch('success', message: 'Stock Category Created!');
            return redirect()->to('/stock-categories');

        }else {
            $this->dispatch('info', message: 'Stock Category Already Exist!');
            $this->resetPage();
        }
    }

    // Edit Stock Category
    public function edit($id)
    {
        $category = StockCategory::find($id);
        $this->categoryID       = $category->id;
        $this->name             = $category->name;
        $this->stock_class_id   = $category->stock_class_id;
        $this->status           = $category->status;
        $this->isEditing        = true;

        $this->dispatch('info', message: 'About to Modify Stock Category!');
    }

    // Update Stock Category
    public function update()
    {
        // Modify Stock
        StockCategory::where('id', $this->categoryID)->first()->update([
            'name'                  => $this->name,
            'stock_class_id'        => $this->stock_class_id,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Stock Category Updated!');
        return redirect()->to('/stock-categories');
    }

    // Delete Stock Category
    public function delete($id)
    {
        StockCategory::find($id)->delete();
        $this->dispatch('error', message: 'Stock Category Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.stock.stock-category-management')->with([
            'categories' => StockCategory::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->paginate(10),

            'classes' => StockClass::where('status', 'Active')->latest()->get()
        ]);
    }
}
