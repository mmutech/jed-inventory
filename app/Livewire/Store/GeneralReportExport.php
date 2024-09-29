<?php

namespace App\Livewire\Store;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Define headings for your Excel columns
        return [
            'Date',
            'PurchaseOrderNumber',
            'Reference',
            'Store',
            'StockCode',
            'Description',
            'LedgerCode',
            'QuantityReceive',
            'QuantityIssue',
            'QuantityBalance',
            'BasicPrice',
            'ValueReceive',
            'ValueIssue',
            'ValueBalance'
        ];
    }
}
