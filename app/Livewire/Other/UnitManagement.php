<?php

namespace App\Livewire\Other;

use App\Models\Unit;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class UnitManagement extends Component
{
    use WithPagination;

    #[Rule('required|unique:units,description')]
    public $description;

    public $unitID, $status, $search = '';
    public $isEditing = false;

    // Create unit
    public function store()
    {
        $this->validate();

        // Create Unit
        if (!Unit::where('description', $this->description)->exists()) {
            Unit::create([
                'description'   => $this->description,
                'status'        => 'Active',
                'created_by'    => Auth::user()->id

            ]);

            $this->dispatch('success', message: 'Unit Created!');

            return redirect()->to('/units');

        }else {
            $this->dispatch('info', message: 'Unit Already Exist!');
        }
    }

    // Edit Unit
    public function edit($id)
    {
        $unit = Unit::find($id);
        $this->unitID               = $unit->id;
        $this->description          = $unit->description;
        $this->status               = $unit->status;
        $this->isEditing            = true;

        $this->dispatch('info', message: 'About to Modify Unit!');
    }

    // Update Unit
    public function update()
    {
        // Modify Unit
        Unit::where('id', $this->unitID)->first()->update([
            'description'           => $this->description,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Unit Updated!');

        return redirect()->to('/units');
    }

    // Delete Unit
    public function delete($id)
    {
        Unit::find($id)->delete();
        $this->dispatch('error', message: 'Unit Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.other.unit-management')->with([
            'units' => Unit::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
