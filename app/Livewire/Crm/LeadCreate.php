<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Segment;
use App\Models\CustomerSupplier;
use App\Models\Remark;
use App\Models\LeadLog;

class LeadCreate extends Component
{
    public $customer_id;
    public $lead_status_id;
    public $lead_source_id;
    public $segment_id;
    public $sub_segment_id;
    public $expected_date;
    public $remark;

    public $leadStatuses;
    public $leadSources;
    public $segments;
    public $subSegments;
    public $customers;

    public function mount()
    {
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->subSegments = [];
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
    }

    public function updatedSegmentId($segmentId)
    {
        $this->subSegments = Segment::where('parent_id', $segmentId)->get();
        $this->sub_segment_id = null; 
    }

    public function submit()
    {
        $this->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'segment_id' => 'required|exists:segments,id',
            'sub_segment_id' => 'nullable|exists:segments,id',
            'expected_date' => 'required|date',
            'remark' => 'nullable|string',
        ]);

        $lead = Lead::create([
            'customer_id' => $this->customer_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'expected_date' => $this->expected_date,
            'assigned_to' => auth()->id(),
            'user_id' => auth()->id(),
        ]);

        if ($this->remark) {
            Remark::create([
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'remark' => $this->remark,
            ]);
        }

        LeadLog::create([
            'lead_id' => $lead->id,
            'id_from' => auth()->id(),
            'log_type' => 'lead_created',
            'details' => 'Lead created with ID ' . $lead->id,
            'id_to' => null,
        ]);

        session()->flash('success', 'Lead added successfully.');
        return redirect()->route('agent.leads.index');
    }

    public function render()
    {
        return view('livewire.crm.lead-create');
    }
}
