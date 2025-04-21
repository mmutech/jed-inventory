<?php

namespace App\Livewire\Stock;

use App\Models\GeneralLedger;
use App\Models\StockCode;
use Livewire\Component;
use Livewire\WithPagination;
use Milon\Barcode\DNS1D; // For 1D barcodes
use App\Models\StockCategory;
use App\Models\StockClass;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;


class StockCodeManagement extends Component
{
    use WithPagination;

    #[Rule('required|unique:stock_codes,stock_code')]
    public $stock_code;

    #[Rule('required')]
    public $name, $unit, $selectedStockCategory, $selectedStockClass,
    $stock_class, $stock_category = null, $gl_code_id;

    public $codeID, $status, $search = '';
    public $barcodeType = 'C39', $barcodeHtml, $stockCodeId, $stockCodeName;

    public $isEditing = false;

    public function mount()
    {
        $this->stock_class          = StockClass::latest()->get();
        $this->stock_category       = collect();

    }

    // Create Stock Code
    public function store()
    {
        $this->validate();

        // Create Stock Code
        StockCode::create([
            'stock_code'            => $this->stock_code,
            'name'                  => $this->name,
            'stock_category_id'     => $this->selectedStockCategory,
            'stock_class_id'        => $this->selectedStockClass,
            'gl_code_id'            => $this->gl_code_id,
            'unit'                  => $this->unit,
            'status'                => 'Active',
            'created_by'            => Auth::user()->id

        ]);

        $this->dispatch('success', message: 'Stock Code Created!');

        // return redirect()->to('/stock-codes');
    }

    // Edit Stock Code
    public function edit($id)
    {
        $this->stock_class          = StockClass::latest()->get();
        $this->stock_category       = collect();

        $code = StockCode::find($id);
        $this->codeID                   = $code->id;
        $this->name                     = $code->name;
        $this->unit                     = $code->unit;
        $this->selectedStockCategory    = $code->stock_category_id;
        $this->selectedStockClass       = $code->stock_class_id;
        $this->gl_code_id               = $code->gl_code_id;
        $this->status                   = $code->status;
        $this->isEditing                = true;

        $this->dispatch('info', message: 'About to Modify Stock Code!');
    }

    // Update Stock Code
    public function update()
    {
        // Modify Stock Code
        StockCode::where('id', $this->codeID)->first()->update([
            'name'                  => $this->name,
            'unit'                  => $this->unit,
            'stock_category_id'     => $this->selectedStockCategory,
            'stock_class_id'        => $this->selectedStockClass,
            'gl_code_id'            => $this->gl_code_id,
            'status'                => $this->status,
            'updated_by'            => Auth::user()->id

        ]);

        $this->dispatch('info', message: 'Stock Code Updated!');

        return redirect()->to('/stock-codes');

    }

    // Delete Stock Code
    public function delete($id)
    {
        StockCode::find($id)->delete();
        $this->dispatch('error', message: 'Stock Code Deleted Successfully.');
        $this->resetPage();
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Filter
    public function updatedSelectedStockClass($stock_class)
    {
        $this->stock_category = StockCategory::where('stock_class_id', $stock_class)->get();
    }

    // Generate Barcode
    public function generateBarcode($stock_code)
    {
        $stockCodeDetails = StockCode::where('stock_code', $stock_code)->first();

        if ($stockCodeDetails) {
            $barcode = new DNS1D();
            $this->barcodeHtml = $barcode->getBarcodeHTML($stock_code, 'C39');
            $this->stockCodeId = $stock_code;
            $this->stockCodeName = $stockCodeDetails->name;

            // $this->emit('barcodeGenerated');
        }
    }

    public function render()
    {
        return view('livewire.stock.stock-code-management')->with([
            'codes' => StockCode::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('stock_code', 'like', '%'.$this->search.'%');
            })->paginate(10),

            'units'             => Unit::latest()->get(),
            'ledgerCodes'       => GeneralLedger::latest()->get(),
        ]);
    }
}
