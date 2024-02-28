<?php

namespace App\Livewire\SRIN;

use Livewire\Component;
use App\Models\SRIN;
use Illuminate\Support\Facades\DB;

class SRINIndex extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.s-r-i-n.s-r-i-n-index')->with([
            'data' => SRIN::select('srin_id', 'srin_code', 'location', 'created_by', 'created_at', DB::raw('COUNT(*) as count'))->latest()
            ->groupBy('srin_id', 'srin_code', 'location', 'created_by', 'created_at',)->where(function ($filter){
                    $filter->where('srin_code', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
