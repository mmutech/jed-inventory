<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockClass;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class StockClassManagement extends Component
{
    use WithPagination;

    #[Rule('required|unique:stock_classes,name')]
    public $name;

    public $classID, $status, $search = '';
    public $isEditing = false;

    // Create Stock Class
    public function store()
    {
        $this->validate();

        // Create Stock Class

        if (!StockClass::where('name', $this->name)->exists()) {
            StockClass::create([
                'name' => $this->name,
                'status' => 'Active',
                'created_by' => Auth::user()->id

            ]);

            $this->dispatch('success', message: 'Stock Class Created!');

            return redirect()->to('/stock-classes');

        }else {
            $this->dispatch('info', message: 'Stock Class Already Exist!');
        }
    }

    // Edit Stock Class
    public function edit($id)
    {
        $class = StockClass::find($id);
        $this->classID              = $class->id;
        $this->name                 = $class->name;
        $this->status               = $class->status;
        $this->isEditing            = true;

        $this->dispatch('info', message: 'About to Modify Stock Class!');
    }

    // Update Stock Class
    public function update()
    {
        // Modify Stock Class
        StockClass::where('id', $this->classID)->first()->update([
            'name'                  => $this->name,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Stock Class Updated!');

        return redirect()->to('/stock-classes');
    }

    // Delete Stock Class
    public function delete($id)
    {
        StockClass::find($id)->delete();
        $this->dispatch('error', message: 'Stock Class Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.stock.stock-class-management')->with([
            'classes' => StockClass::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
