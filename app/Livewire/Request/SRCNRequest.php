<?php

namespace App\Livewire\Request;

use App\Models\RequestItemTable;
use Livewire\Component;
use App\Models\StockCode;
use App\Models\Store;
use App\Models\StoreBook;
use Illuminate\Support\Facades\DB;

class SRCNRequest extends Component
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

    public function srcnId()
    {
        // Generate a new reference ID
        $lastRecord = DB::table('request_item_tables')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(reference, "-", -1) AS UNSIGNED)'), 'desc')
        ->first();

        if ($lastRecord) {
            // Extract the numeric part from the last reference
            $lastReference = $lastRecord->reference;
            $numericPart = (int) substr(strrchr($lastReference, '-'), 1);
        
            // Increment the numeric part
            $newNumericPart = $numericPart + 1;
        
            // Define the prefix (you can set this dynamically as needed)
            $prefix = 'SRCN-';
        
            // Generate the new reference ID
            $newReferenceId = $prefix . $newNumericPart;
        } else {
            // If there is no last record, start with the first reference ID
            $newReferenceId = 'SRCN-1';
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
        ];
        
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
            'requisition_date' => now(),
            'added_by' => Auth()->user()->id,
        ]);

        // Reset input fields
        $this->selectedStockCode = '';
        $this->quantity_required = '';
    }

    public function render()
    {
        return view('livewire.request.s-r-c-n-request')->with([
            'stock_code' => StockCode::where('status', 'Active')->get(),
        ]);
    }

    public function updatedSelectedStockCode()
    {
        // Update the available stock whenever the stock code is selected/changed
        $this->stockCount = StoreBook::select('station_id', DB::raw('MAX(id) as latest_id'))
        ->where('stock_code_id', $this->selectedStockCode)
        ->groupBy('station_id')
        ->pluck('latest_id');

        // Now sum the qty_balance of those latest records
        $this->stockCount = StoreBook::whereIn('id', $this->stockCount)->sum('qty_balance');
    }
}
