<?php

namespace App\Livewire\Other;

use App\Models\location;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class StoreManagement extends Component
{
    use WithPagination;

    public $storeID, $status, $search = '';

    public $isEditing = false;

    #[Rule('required|unique:stores,name')]
    public $name;

    #[Rule('required')]
    public $store_officer, $location;

    public function store()
    {
        $this->validate();

        // Create Store
        Store::create([
            'name'              => $this->name,
            'location'          => $this->location,
            'store_officer'     => $this->store_officer,
            'status'            => 'Active',
            'created_by'        => Auth::user()->id

        ]);

        $this->dispatch('success', message: 'Store Created!');

        return redirect()->to('/stores');
    }

    // Edit Store
    public function edit($id)
    {
        $store = Store::find($id);
        $this->storeID              = $store->id;
        $this->name                 = $store->name;
        $this->location             = $store->location;
        $this->store_officer        = $store->store_officer;
        $this->status               = $store->status;
        $this->isEditing            = true;

        $this->dispatch('info', message: 'About to Modify Store!');
    }

    // Update Store
    public function update()
    {
        // Modify Store
        Store::where('id', $this->storeID)->first()->update([
            'name'                  => $this->name,
            'location'              => $this->location,
            'store_officer'         => $this->store_officer,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Store Updated!');

        return redirect()->to('/stores');
    }

    // Delete Store
    public function delete($id)
    {
        Store::find($id)->delete();
        $this->dispatch('error', message: 'Store Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.other.store-management')->with([
            'stores' => Store::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('location', 'like', '%'.$this->search.'%');
            })->paginate(10),

            'officers' => User::latest()->get(),
            'locations' => location::latest()->get(),
        ]);
    }
}
