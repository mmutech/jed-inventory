<?php

namespace App\Livewire\Stock;

use App\Models\GeneralLedger;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class GeneralLedgerManagement extends Component
{
    use WithPagination;

    #[Rule('required')]
    public $name;

    #[Rule('required|unique:general_ledgers,code')]
    public $code;

    #[Rule('required')]
    public $category;

    public $ledgerID, $search = '';
    public $isEditing = false;

    // Clear form fields
    private function resetFields()
    {
        $this->name = '';
        $this->code = '';
        $this->category = '';
        $this->ledgerID = null;
        $this->isEditing = false;
    }

    // Store General Ledger
    public function store()
    {
        $this->validate();

        GeneralLedger::create([
            'name'          => $this->name,
            'code'          => $this->code,
            'category'      => $this->category,
            'created_by'    => Auth()->id(),

        ]);

        $this->dispatch('success', message: 'General Ledger Created Successfully.');
        $this->resetPage();
        $this->resetFields();
    }

    // Edit General Ledger
    public function edit($id)
    {
        $ledger = GeneralLedger::find($id);
        $this->ledgerID     = $ledger->id;
        $this->name         = $ledger->name;
        $this->code         = $ledger->code;
        $this->category     = $ledger->category;
        $this->isEditing    = true;

        $this->dispatch('info', message: 'General Ledger Not Exist!');
    }

    // Update General Ledger
    public function update()
    {
        if (GeneralLedger::where('id', $this->ledgerID)->exists()) {
            $ledger = GeneralLedger::find($this->ledgerID);

            // Update General Ledger
            $ledger->name            = $this->name;
            $ledger->code            = $this->code;
            $ledger->category        = $this->category;
            $ledger->updated_by      = Auth()->id();

            $ledger->save();

            $this->dispatch('info', message: 'General Ledger Updated Successfully.');
            $this->resetPage();
        } else {
            $this->dispatch('info', message: 'General Ledger Not Exist!');
            $this->resetPage();
        }
    }

    // Delete General Ledger
    public function delete($id)
    {
        GeneralLedger::find($id)->delete();
        $this->dispatch('error', message: 'General Ledger Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.stock.general-ledger-management')->with([
            'ledgers' => GeneralLedger::latest()
            ->where(function ($filter){
                    $filter->where('code', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('category', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
