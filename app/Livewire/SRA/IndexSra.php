<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SRA;


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
            'data' => SRA::latest()->where(function ($filter){
                $filter->where('sra_code', 'like', '%'.$this->search.'%')
                    ->orWhere('invoice_no', 'like', '%'.$this->search.'%')
                    ->orWhere('consignment_note_no', 'like', '%'.$this->search.'%');
            })->paginate(5),
        ]);
    }
}
