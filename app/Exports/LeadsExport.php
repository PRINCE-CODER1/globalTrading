<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Contractor;

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
            $contractorIds = is_string($lead->contractor_ids) 
                             ? explode(',', $lead->contractor_ids) 
                             : $lead->contractor_ids;
            $contractorNames = Contractor::whereIn('id', $contractorIds)
                            ->pluck('name')
                            ->implode(', ');
            return [
                'reference_id' => $lead->reference_id,
                'customer' => $lead->customer->name ?? 'N/A',
                'customer User' => $lead->customerUser->name  ?? 'N/A',
                'assigned_agent' => $lead->assignedAgent->name ?? 'N/A',
                'category' => $lead->category->name ?? 'N/A',
                'subcategory' => $lead->ChildCategory->name ?? 'N/A',
                'status' => $lead->leadStatus->name ?? 'N/A',
                'series' => $lead->Series->name ?? 'N/A',
                'segment' => $lead->segment->name ?? 'N/A',
                'sub-segment' => $lead->subSegment->name ?? 'N/A',
                'amount' => $lead->amount ?? 'N/A',
                'application' => $lead->application->name ?? 'N/A',
                'lead_type' => $lead->leadType->name ?? 'N/A',
                'contractor' => $contractorNames ?: 'N/A',
                'specification' => $lead->specification ?? 'N/A',
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
            'Customer User',
            'Assigned Agent',
            'Category',
            'subCategory',
            'Status',
            'Series',
            'Segment',
            'Subsegment',
            'Amount',
            'Apllication',
            'Lead Type',
            'Contractor',
            'specification',
            'Expected Date',
            'Next Follow-Up Date',
            'Capture Date',
            'Source',
            'Team',
        ];
    }
}
