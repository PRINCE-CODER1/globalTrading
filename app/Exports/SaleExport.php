<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleExport implements FromCollection, WithHeadings
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        return $this->sales->map(function ($sale, $index) {
            return [
                'sr_no'        => $index + 1,
                'sale_no'      => $sale->sale_no,
                'customer'     => $sale->customer->name ?? 'N/A',
                'branch'       => $sale->branch->name ?? 'N/A',
                'amount'       => $sale->items->sum('price'),
                'sale_date'    => $sale->sale_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SR. No',
            'Sale No',
            'Customer',
            'Branch',
            'Amount',
            'Sale Date',
        ];
    }
}
