<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\WithPagination;
use App\Models\SRA;
use App\Models\SRARemark;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class IndexSra extends Component
{
    public $search = '';

    // public function mount($poID)
    // {
    //     $this->poID = $poID;
    //     // dd($approved);
    // }

    public function render()
    {
        return view('livewire.s-r-a.index-sra')->with([
            'data' => SRARemark::latest()->paginate(5),
        ]);
    }
}
