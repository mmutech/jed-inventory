<?php

namespace App\Livewire\Request;

use App\Models\RequestItemTable;
use App\Models\Store;
use App\Models\StockCode;
use App\Models\StoreBook;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SRINRequest extends Component
{
    public $referenceId, $storeID;
    public $quantity_required, $quantity_issued, $work_location, $job_description;
    public $lastNumber;
    public $stocks = [];
    public $showInputFields = false;
    public $selectedStockCode;
    public $stockCount = 0;

    public function mount()
    {
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();

        // Initialize with an empty reference ID
        $this->referenceId = null;
    }

    public function srinId()
    {
        // Generate a new reference 
        $prefix = 'SRIN';
        $this->showInputFields = true;

        $lastRecord = DB::table('request_item_tables')
            ->where(DB::raw('SUBSTRING_INDEX(reference, "-", 1)'), $prefix)
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(reference, "-", -1) AS UNSIGNED)'), 'desc')
            ->first();

        if ($lastRecord) {
            // Extract the numeric part from the last reference
            $lastReference = $lastRecord->reference;
            $numericPart = (int) substr(strrchr($lastReference, '-'), 1);
        
            // Increment the numeric part
            $newNumericPart = $numericPart + 1;
        
            // Define the prefix (you can set this dynamically as needed)
            $prefix = 'SRIN-';
        
            // Generate the new reference ID
            $newReferenceId = $prefix . $newNumericPart;
        } else {
            // If there is no last record, start with the first reference ID
            $newReferenceId = 'SRIN-1';
        }

        $this->referenceId = $newReferenceId;
        // Reset the stocks array for new entries
        $this->stocks = [];
    }

    public function addReqStock()
    {
        // Validate the input
        $rules = [
            'selectedStockCode' => 'required|integer',
            'quantity_required' => 'required|integer|min:1',
            'work_location' => 'required',
            'job_description' => 'required',
        ];
        
        if ($this->showInputFields) {
            
        }
        
        $this->validate($rules);

        // Add the stock data to the array
        $this->stocks[] = [
            'referenceId' => $this->referenceId,
            'stockCode' => $this->selectedStockCode,
            'quantity_required' => $this->quantity_required,
        ];

        // Store to database
        RequestItemTable::create([
            'reference' => $this->referenceId,
            'stock_code_id' => $this->selectedStockCode,
            'quantity_required' => $this->quantity_required,
            'requisition_store' => $this->storeID,
            'work_location' => $this->work_location,
            'job_description' => $this->job_description,
            'requisition_date' => now(),
            'added_by' => Auth()->user()->id,
        ]);

        // Reset input fields
        $this->selectedStockCode = '';
        $this->quantity_required = '';
    }

    public function render()
    {
        return view('livewire.request.s-r-i-n-request')->with([
            'stock_code' => StockCode::where('status', 'Active')->get(),
        ]);
    }

    public function updatedSelectedStockCode()
    {
        // Update the available stock whenever the stock code is selected/changed
        $this->stockCount = StoreBook::select('station_id', DB::raw('MAX(id) as latest_id'))
        ->where('station_id', $this->storeID)
        ->where('stock_code_id', $this->selectedStockCode)
        ->groupBy('station_id')
        ->pluck('latest_id');

        // Now sum the qty_balance of those latest records
        $this->stockCount = StoreBook::whereIn('id', $this->stockCount)->sum('qty_balance');
    }
}
