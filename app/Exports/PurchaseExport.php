<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithHeadings
{
    protected $purchases;

    public function __construct($purchases)
    {
        $this->purchases = $purchases;
    }

    public function collection()
    {
        return $this->purchases->map(function ($purchase, $index) {
            return [
                'sr_no'        => $index + 1,
                'purchase_no'  => $purchase->purchase_no,
                'supplier'     => $purchase->supplier->name ?? 'N/A',
                'branch'       => $purchase->branch->name ?? 'N/A',
                'sub_total' => $purchase->items->sum('sub_total'),
                'purchase_date'=> $purchase->purchase_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SR. No',
            'Purchase No',
            'Supplier',
            'Branch',
            'Sub Amount',
            'Purchase Date',
        ];
    }
}
