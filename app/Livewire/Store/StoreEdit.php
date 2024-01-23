<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\Store;
use App\Models\User;
use App\Models\location;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StoreEdit extends Component
{
    public $title = 'Modify Store';

    public $storeID;

    #[Locked]
    public $stID;

    #[Rule('required')]
    public $name, $store_officer, $location, $status;

    public function update()
    {
        $this->validate();

        // Modify Store
        if (Store::where('id', $this->stID)->exists()) {
            Store::where('id', $this->stID)->first()->update([
                'name' => $this->name,
                'location' => $this->location,
                'store_officer' => $this->store_officer,
                'status' => $this->status,
                'updated_by' => Auth::user()->id

            ]); 

            $this->dispatch('info', message: 'Store Updated!');

            return redirect()->to('/store-index');

        }else {
            $this->dispatch('info', message: 'Store Already Exist!');
        }
    }

    public function mount($stID)
    {
        $this->stID = $stID;

        // Edit
        $data = Store::where('id', $this->stID)->get();
        if ($data->count() > 0) {

            foreach ($data as $key => $store) {
                $this->storeID = $store->id;
                $this->name = $store->name;
                $this->location = $store->location;
                $this->store_officer = $store->store_officer;
                $this->status = $store->status;
            }
        } else {
            $this->dispatch('info', message: 'Store Not Exist!');
            return redirect()->to('/store-index');
        }

    }

    public function render()
    {
        return view('livewire.store.store-edit')->with([
            'users' => User::latest()->get(),
            'locations' => location::latest()->get(),
        ]);
    }
}
