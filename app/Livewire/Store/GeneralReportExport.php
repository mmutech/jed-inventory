<?php

namespace App\Livewire\Store;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class GeneralReportExport implements FromCollection, WithHeadings, WithStyles
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
            'Date(Receive/Issue)',
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

    public function styles(Worksheet $sheet)
    {
         // Find the row where 'Date' column is 'Total'
         $totalRowIndex = null;
        
         foreach ($this->data as $index => $row) {
             if ($row['LedgerCode'] === 'Cumulative:') {
                 $totalRowIndex = $index + 2; // Add 2: 1 for headings, 1 for 1-based index
                 break;
             }
         }

         if ($totalRowIndex) {
            return [
                // Styling the last row (Total row)
                $totalRowIndex => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '808080'],  // Red background
                    ],
                ],
            ];
         }
         return [];
    }
}
