<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use App\Models\Store;
use App\Models\User;
use App\Models\location;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class StoreCreate extends Component
{
    public $title = 'Create Store';

    #[Locked]
    public $stID;

    #[Rule('required')]
    public $name, $store_officer, $location;

    public function store()
    {
        $this->validate();

        // Create Store
        $lastRecord = Store::latest()->first();
        $stID = $lastRecord ? $lastRecord->store_id + 1 : 1;

        if (!Store::where('store_officer', $this->store_officer)->exists()) {
            Store::create([
                'store_id' => $stID,
                'name' => $this->name,
                'location' => $this->location,
                'store_officer' => $this->store_officer,
                'status' => 'Active',
                'created_by' => Auth::user()->id

            ]); 

            $this->dispatch('success', message: 'Store Created!');

            return redirect()->to('/store-index');

        }else {
            $this->dispatch('info', message: 'Store Already Exist!');
        }
    }

    public function render()
    {
        return view('livewire.store.store-create')->with([
            'users' => User::latest()->get(),
            'locations' => location::latest()->get(),
        ]);
    }
}
