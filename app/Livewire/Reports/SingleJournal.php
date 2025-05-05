<?php

namespace App\Livewire\Reports;

use App\Models\JournalModel;
use App\Models\StoreBook;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SingleJournal extends Component
{
    public $data, $journalID, $journal, $totalValueReceive, $totalValueIssue;

    public function mount($journalID){

        $this->journalID = $journalID;

        $this->journal = JournalModel::where('id', $this->journalID)->first();

        $this->data = StoreBook::select(
            'general_ledgers.code AS GlCode',
            'general_ledgers.name AS GlName',
            DB::raw("SUM(store_books.value_in) AS ValueReceive"),
            DB::raw("SUM(store_books.value_out) AS ValueIssue")
        )
        ->leftJoin('stock_codes', 'store_books.stock_code_id', '=', 'stock_codes.id')
        ->leftJoin('general_ledgers', 'stock_codes.gl_code_id', '=', 'general_ledgers.id')
        ->whereBetween('store_books.date', [$this->journal->start_date, $this->journal->end_date])
        ->groupBy('general_ledgers.code', 'general_ledgers.name') // Group by GL code and name
        ->get();

        $this->totalValueReceive = $this->data->sum('ValueReceive');
        $this->totalValueIssue = $this->data->sum('ValueIssue');

        // dd($this->totalValueReceive);

    }

    public function authorized()
    {
        if ($this->journalID) {
            JournalModel::where('id', $this->journalID)->update([
                'authorized_date'     => now(),
                'authorized_by'       => Auth()->user()->id,
            ]);
        }

        $this->dispatch('success', message: 'Journal Authorized!');
        return redirect()->to('single-journal/' . $this->journalID);

    }

    public function render()
    {
        return view('livewire.reports.single-journal');
    }
}
