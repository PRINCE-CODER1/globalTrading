<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\SaleOrder;

class SaleOrderExport implements FromCollection, WithHeadings
{
    protected $saleOrders;

    public function __construct($saleOrders)
    {
        $this->saleOrders = $saleOrders;
    }

    public function collection()
    {
        return $this->saleOrders->map(function ($sale, $index) {
            return [
                'sr_no'       => $index + 1,
                'customer'    => $sale->customer->name ?? 'N/A',
                'invoice_no'  => $sale->sale_order_no,
                'invoice_date'=> $sale->date,
                'amount'      => $sale->items->sum('sub_total'),
                'branch_name' => $sale->orderBranch->name ?? 'N/A',
                'agent'       => $sale->agent->name ?? 'N/A',
                'lead_source' => $sale->leadSource->name ?? 'N/A',
                'segment'     => $sale->segment->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SR. No',
            'Customer/Both',
            'Invoice No',
            'Invoice Date',
            'Amount',
            'Branch Name',
            'Agent',
            'Lead Source',
            'Segment',
        ];
    }
}
