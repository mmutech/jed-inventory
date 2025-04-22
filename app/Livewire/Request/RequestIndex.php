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

    public $storeID, $data, $scn;
    public $search = '';

    public function srcnId()
    {
        $query = RequestItemTable::select('reference', DB::raw('COUNT(stock_code_id) AS count'), 'status')
            // ->where('requisition_store', $this->storeID)
            ->where('reference', 'like', 'SRCN-%')
            ->groupBy('reference', 'status')
            ->where(function ($filter) {
                if ($this->search) {
                    $filter->where('reference', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy(DB::raw('MAX(created_at)'), 'desc');

            if (auth()->user()->hasRole('Store-Officer')) {
                $query->where('requisition_store', $this->storeID);
            }

        $paginatedData = $query->paginate(10);

        // Extract only the items (data records) for Livewire property
        $this->data = $paginatedData->items();
        // $this->data = '';
    }

    public function srinId()
    {
        $query = RequestItemTable::select('reference', DB::raw('COUNT(stock_code_id) AS count'), 'status')
            ->where('reference', 'like', 'SRIN-%')
            ->groupBy('reference', 'status')
            ->where(function ($filter) {
                if ($this->search) {
                    $filter->where('reference', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy(DB::raw('MAX(created_at)'), 'desc');

            if (auth()->user()->hasRole('Store-Officer')) {
                $query->where('requisition_store', $this->storeID);
            }

        $paginatedData = $query->paginate(10);

        // Extract only the items (data records) for Livewire property
        $this->data = $paginatedData->items();
    }

    public function mount()
    {
        // Get Store ID
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // Get the requested data
        $query = RequestItemTable::select('reference', DB::raw('COUNT(stock_code_id) AS count'), 'status')
        ->groupBy('reference', 'status');

        // if (auth()->user()->hasRole('Store-Officer')) {
        //     $query->where('requisition_store', $this->storeID);
        // }
        $this->data = $query->get();

        // dd($this->data);
    }

    public function render()
    {
        // Request Category Count
        $srcn = RequestItemTable::select('reference')->where('reference', 'like', 'SRCN-%')
          ->groupBy('reference')
          ->get();

        $srin = RequestItemTable::select('reference')->where('reference', 'like', 'SRIN-%')
          ->groupBy('reference')
          ->get();

        if (auth()->user()->hasRole('Store-Officer')) {
            $srin->where('requisition_store', $this->storeID);
            $srcn->where('requisition_store', $this->storeID);
        }

        return view('livewire.request.request-index')->with([
            'srcnCount' => $srcn->count(),
            'srinCount' => $srin->count(),
        ]);
    }
}
