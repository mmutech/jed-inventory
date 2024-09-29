<?php

namespace App\Livewire\Store;

use App\Models\StoreBook;
use Livewire\Component;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class GeneralReport extends Component
{
    public $startDate, $endDate;

    // Function to generate and export the report
    public function exportReport()
    {
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

            // Retrieve data based on $startDate and $endDate
        $data = StoreBook::select(
            'store_books.date AS Date',
            'purchase_orders.purchase_order_no AS PurchaseOrderNumber',  
            'store_books.reference AS Reference',
            'stores.name AS Store',
            'stock_codes.stock_code AS stockCode',
            'stock_codes.name AS Description',
            'stock_codes.gl_code_id  AS LedgerCode',
            'store_books.qty_in AS QuantityReceive',
            'store_books.qty_out AS QuantityIssue',
            'store_books.qty_balance AS QuantityBalance',
            'store_books.basic_price AS BasicPrice',
            'store_books.value_in AS ValueReceive',
            'store_books.value_out AS ValueIssue',
            'store_books.value_balance AS ValueBalance'
        )
        ->leftJoin('purchase_orders', 'store_books.purchase_order_id', '=', 'purchase_orders.purchase_order_id')
        ->leftJoin('stock_codes', 'store_books.stock_code_id', '=', 'stock_codes.id')
        ->leftJoin('stores', 'store_books.station_id', '=', 'stores.store_id')
        ->whereBetween('store_books.date', [$startDate, $endDate])
        ->get();

        // dd($data);
        if ($data->count() == 0) {
            $this->dispatch('warning', message: 'No Record Found!');
        }else {
            // Calculate cumulative totals
            $totalReceive = $data->sum('QuantityReceive');
            $totalIssue = $data->sum('QuantityIssue');
            $totalBalance = number_format(round($totalReceive - $totalIssue, 2));

            $totalValReceive = $data->sum('ValueReceive');
            $totalValIssue = $data->sum('ValueIssue');
            $totalValBalance = number_format(round($totalValReceive - $totalValIssue, 2));

            // Append totals to the dataset (for example as the last row)
            $data->push([
                'Date' => '',
                'PurchaseOrderNumber' => '',
                'Reference' => '',
                'Store' => '',
                'stockCode' => '',
                'Description' => '',
                'LedgerCode' => 'Cumulative:',
                'QuantityReceive' => $totalReceive,
                'QuantityIssue' => $totalIssue,
                'QuantityBalance' => $totalBalance,
                'BasicPrice' => '',
                'ValueReceive' => $totalValReceive,
                'ValueIssue' => $totalValIssue,
                'ValueBalance' => $totalValBalance,
            ]);

            // Generate Excel file using Laravel Excel
            return Excel::download(new GeneralReportExport($data), 'general_report.xlsx');
        }
    }

    public function render()
    {
        return view('livewire.store.general-report');
    }
}
