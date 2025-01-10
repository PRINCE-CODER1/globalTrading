<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    protected $leads;

    // Pass the filtered leads to the constructor
    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->leads->map(function ($lead) {
            return [
                'reference_id' => $lead->reference_id,
                'customer' => $lead->customer->name ?? 'N/A',
                'assigned_agent' => $lead->assignedAgent->name ?? 'N/A',
                'status' => $lead->leadStatus->name ?? 'N/A',
                'expected_date' => $lead->expected_date,
                'next_follow_up_date' => $lead->remarks->last()?->date ?? 'N/A',
                'capture_date' => $lead->created_at->format('Y-m-d'),
                'source' => $lead->leadSource->name ?? 'N/A',
                'team' => $lead->assignedAgent->teams->pluck('name')->implode(', ') ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Reference ID',
            'Customer',
            'Assigned Agent',
            'Status',
            'Expected Date',
            'Next Follow-Up Date',
            'Capture Date',
            'Source',
            'Team',
        ];
    }
}
