<?php

namespace App\Livewire\Request;

use App\Models\RequestItemTable;
use App\Models\StockCode;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class RequestItem extends Component
{
    public $referenceId, $storeID;
    public $stockCode;
    public $quantity_required, $quantity_issued, $work_location, $job_description;
    public $lastNumber;
    public $stocks = [];
    public $showInputFields = false;

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
        // Ensure a reference ID exists; if not, generate one
        if (!$this->referenceId) {
            $this->srcnId();
        }

        // Validate the input
        $rules = [
            'stockCode' => 'required|integer',
            'quantity_required' => 'required|integer|min:1',
        ];
        
        if ($this->showInputFields) {
            $rules['work_location'] = 'required';
            $rules['job_description'] = 'required';
        }
        
        $this->validate($rules);

        // Add the stock data to the array
        $this->stocks[] = [
            'referenceId' => $this->referenceId,
            'stockCode' => $this->stockCode,
            'quantity_required' => $this->quantity_required,
        ];

        // Store to database
        RequestItemTable::create([
            'reference' => $this->referenceId,
            'stock_code_id' => $this->stockCode,
            'quantity_required' => $this->quantity_required,
            'requisition_store' => $this->storeID,
            'work_location' => $this->work_location,
            'job_description' => $this->job_description,
            'requisition_date' => now(),
            'added_by' => Auth()->user()->id,
        ]);

        // Reset input fields
        $this->stockCode = '';
        $this->quantity_required = '';
    }

    public function render()
    {
        return view('livewire.request.request-item')->with([
            'stock_code' => StockCode::where('status', 'Active')->latest()->get(),
        ]);
    }
}
