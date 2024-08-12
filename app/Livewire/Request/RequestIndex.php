<?php

namespace App\Livewire\Request;

use App\Models\RequestItemTable;
use App\Models\SCNRequestTable;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class RequestIndex extends Component
{
    use WithPagination;
    
    public $storeID, $data, $srcnCount, $srinCount, $scn;
    public $search = '';


    public function srcnId()
    {
        $query = RequestItemTable::select('reference', DB::raw('COUNT(stock_code_id) AS count'))
            // ->where('requisition_store', $this->storeID)
            ->where('reference', 'like', 'SRCN-%')
            ->groupBy('reference')
            ->where(function ($filter) {
                if ($this->search) {
                    $filter->where('reference', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy(DB::raw('MAX(created_at)'), 'desc');

        $paginatedData = $query->paginate(10);

        // Extract only the items (data records) for Livewire property
        $this->data = $paginatedData->items();
        // $this->data = '';
    }

    public function srinId()
    {
        $query = RequestItemTable::select('reference', DB::raw('COUNT(stock_code_id) AS count'))
            // ->where('requisition_store', $this->storeID)
            ->where('reference', 'like', 'SRIN-%')
            ->groupBy('reference')
            ->where(function ($filter) {
                if ($this->search) {
                    $filter->where('reference', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy(DB::raw('MAX(created_at)'), 'desc');

        $paginatedData = $query->paginate(10);

        // Extract only the items (data records) for Livewire property
        $this->data = $paginatedData->items();
        // $this->data = '';
    }

    public function mount()
    {
        // Get Store ID
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // Request Category Count
        $this->srcnCount = RequestItemTable::select('reference')->where('reference', 'like', 'SRCN-%')
        ->groupBy('reference')
        ->get()
        ->count();

        $this->srinCount = RequestItemTable::select('reference')->where('reference', 'like', 'SRIN-%')
        ->groupBy('reference')
        ->get()
        ->count();

    }

    public function render()
    {
        return view('livewire.request.request-index');
    }
}
