<?php

namespace App\Livewire\SCN;

use Livewire\Component;
use App\Models\SCN;
use Illuminate\Support\Facades\DB;

class SCNIndex extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.s-c-n.s-c-n-index')->with([
            'data' => SCN::select('scn_id', 'scn_code', 'job_from', 'created_by', 'returned_date', DB::raw('COUNT(*) as count'))->latest()
            ->groupBy('scn_id', 'scn_code', 'job_from', 'created_by', 'returned_date')->where(function ($filter){
                $filter->where('scn_code', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
