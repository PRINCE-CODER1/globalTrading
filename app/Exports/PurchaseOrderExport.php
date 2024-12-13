<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrderExport implements FromCollection, WithHeadings
{
    protected $purchaseOrders;

    public function __construct($purchaseOrders)
    {
        $this->purchaseOrders = $purchaseOrders;
    }

    public function collection()
    {
        return $this->purchaseOrders->map(function ($order, $index) {
            return [
                'sr_no'         => $index + 1,
                'supplier'      => $order->supplier->name ?? 'N/A',
                'invoice_no'    => $order->purchase_order_no,
                'invoice_date'  => $order->date,
                'amount'        => $order->items->sum('price'),
                'segment'       => $order->segment->name ?? 'N/A',
                'order_branch'  => $order->orderBranch->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SR. No',
            'Supplier',
            'Invoice No',
            'Invoice Date',
            'Amount',
            'Segment',
            'Order Branch',
        ];
    }
}
