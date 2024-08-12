<?php

namespace App\Livewire\Request;

use App\Models\RequestItemTable;
use App\Models\SCNRequestTable;
use App\Models\StockCode;
use App\Models\Store;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SCNRequest extends Component
{
    public $referenceId, $storeID, $data, $srinId, $stockCodeIDs;
    public $stocks = [];
    public $quantity_return, $work_location, $job_description, $stockCode, $quantity_returned;

    public function scnId()
    {
        // Generate a new reference ID
        $prefix = 'SCN';

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
            $prefix = 'SCN-';
        
            // Generate the new reference ID
            $newReferenceId = $prefix . $newNumericPart;
        } else {
            // If there is no last record, start with the first reference ID
            $newReferenceId = 'SCN-1';
        }

        $this->referenceId = $newReferenceId;
        // Reset the stocks array for new entries
        $this->stocks = [];
    }

    public function addReqStock()
    {
        // Ensure a reference ID exists; if not, generate one
        if (!$this->referenceId) {
            $this->scnId();
        }

        // Validate the input
        $rules = [
            'stockCode' => 'required|integer',
            'quantity_returned' => 'required|integer|min:1',
        ];
        
        $this->validate($rules);

        // Add the stock data to the array
        $this->stocks[] = [
            'referenceId' => $this->referenceId,
            'stockCode' => $this->stockCode,
            'quantity_returned' => $this->quantity_returned,
        ];

        // Store to database
        SCNRequestTable::create([
            'reference' => $this->referenceId,
            'stock_code_id' => $this->stockCode,
            'quantity_returned' => $this->quantity_returned,
            'srin_id' => $this->srinId,
            'return_date' => now(),
            'added_by' => Auth()->user()->id,
        ]);

        // Reset input fields
        $this->stockCode = '';
        $this->quantity_returned = '';
    }

    public function mount($srinId)
    {
        $this->srinId = $srinId;

        $this->data = RequestItemTable::where('reference', $this->srinId)->first();
        $this->storeID = Store::where('store_officer', Auth()->user()->id)->pluck('id')->first();
        $this->stockCodeIDs = RequestItemTable::where('reference', $this->srinId)->pluck('stock_code_id');

        $this->work_location = $this->data->work_location;
        $this->job_description = $this->data->job_description;

        // Initialize with an empty reference ID
        $this->referenceId = null;
    }

    public function render()
    {
        return view('livewire.request.s-c-n-request')->with([
            'stock_code' => StockCode::whereIn('id', $this->stockCodeIDs)->get(),
        ]);
    }
}
