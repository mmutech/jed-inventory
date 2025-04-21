<?php

namespace App\Livewire\Other;

use App\Models\location;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class LocationManagement extends Component
{
    use WithPagination;

    #[Rule('required|unique:locations,name')]
    public $name;

    public $locationID, $status, $search = '';
    public $isEditing = false;

    // Create Location
    public function store()
    {
        $this->validate();

        // Create Location
        if (!location::where('name', $this->name)->exists()) {
            location::create([
                'name'          => $this->name,
                'status'        => 'Active',
                'created_by'    => Auth::user()->id

            ]);

            $this->dispatch('success', message: 'Location Created!');

            return redirect()->to('/locations');

        }else {
            $this->dispatch('info', message: 'Location Already Exist!');
        }
    }

    // Edit Location
    public function edit($id)
    {
        $location = location::find($id);
        $this->locationID           = $location->id;
        $this->name                 = $location->name;
        $this->status               = $location->status;
        $this->isEditing            = true;

        $this->dispatch('info', message: 'About to Modify Location!');
    }

    // Update Location
    public function update()
    {
        // Modify Location
        location::where('id', $this->locationID)->first()->update([
            'name'                  => $this->name,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Location Updated!');

        return redirect()->to('/locations');
    }

    // Delete Location
    public function delete($id)
    {
        location::find($id)->delete();
        $this->dispatch('error', message: 'Location Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.other.location-management')->with([
            'locations' => location::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
