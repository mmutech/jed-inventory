<?php

namespace App\Livewire\Reports;

use App\Models\JournalModel;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Journal extends Component
{
    use WithPagination;

    #[Rule('required')]
    public $startDate, $endDate;

    public $search = '';

    public function generate()
    {
        $this->validate();

        $journal = JournalModel::create([
            'start_date'        => $this->startDate,
            'end_date'          => $this->endDate,
            'prepared_date'     => now(),
            'prepared_by'       => Auth()->user()->id,
        ]);

        $journalID = $journal->id;

        $this->dispatch('success', message: 'Journal Created Successfully!');
        return redirect()->to('single-journal/' . $journalID);

    }

    public function render()
    {
        return view('livewire.reports.journal')->with([
            'journals' => JournalModel::where('prepared_date', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5)
        ]);
    }
}
