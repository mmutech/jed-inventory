<?php

namespace App\Livewire\Stock\Code;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockCode;
use Milon\Barcode\DNS1D; // For 1D barcodes

class StockCodeIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $barcodeType = 'C39', $barcodeHtml, $stockCodeId, $stockCodeName;

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
        return view('livewire.stock.code.stock-code-index')->with([
            'data' => StockCode::latest()
            ->where(function ($filter){
                    $filter->where('status', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('stock_code', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ]);
    }
}
