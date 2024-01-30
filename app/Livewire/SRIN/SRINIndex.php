<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use App\Models\SRIN;

class SRINIndex extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-index')->with([
            'data' => SRIN::latest()->paginate(5),
        ]);
    }
}
