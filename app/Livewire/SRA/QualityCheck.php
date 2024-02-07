<?php

namespace App\Livewire\SRA;

use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Models\SRA;
use App\Models\QualityChecks;
use App\Models\PurchaseOrders;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class QualityCheck extends Component
{
    public $title = 'Quality Check';

    public $item;

    #[Rule('required')]
    public $quality_check_note, $quality_check_action;

    #[Locked]
    public $poID;

    public function qualityCheck($id)
    {
        Item::where('id', $id)->first()->update([
            'quality_check' => 1,
        ]);

    }

    public function qualityCheckRemark()
    {
         // Validation
        //  $this->validate();
         
        // Quality Check Remark
        QualityChecks::create([
            'reference' => $this->poID,
            'quality_check_note' => $this->quality_check_note,
            'quality_check_date' => now(),
            'quality_check_by' => Auth::user()->id
        ]);

        $this->dispatch('info', message: 'Quality Checks Completed!');
        return redirect()->to('show-sra/' . $this->poID);

    }

    public function mount($poID)
    {
        $this->poID = $poID;

        // dd($approved);
    }

    public function render()
    {
        return view('livewire.s-r-a.quality-check')->with([
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
