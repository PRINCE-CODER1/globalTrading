<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\CustomerSupplier;
use App\Models\Segment;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Remark;
use Illuminate\Support\Facades\Auth;

class LeadEdit extends Component
{
    public $lead;
    public $customer_id, $lead_status_id, $lead_source_id, $segment_id, $sub_segment_id, $expected_date, $remark;
    public $customers, $leadStatuses, $leadSources, $segments, $subSegments, $remarks;

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'lead_status_id' => 'required|exists:lead_statuses,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'segment_id' => 'required|exists:segments,id',
        'sub_segment_id' => 'nullable|exists:segments,id',
        'expected_date' => 'required|date',
        'remark' => 'nullable|string|max:255',
    ];

    public function mount($leadId)
    {
        // Load lead data and related entities
        $this->lead = Lead::findOrFail($leadId);
        $this->customer_id = $this->lead->customer_id;
        $this->lead_status_id = $this->lead->lead_status_id;
        $this->lead_source_id = $this->lead->lead_source_id;
        $this->segment_id = $this->lead->segment_id;
        $this->sub_segment_id = $this->lead->sub_segment_id;
        $this->expected_date = $this->lead->expected_date;
        $this->remarks = $this->lead->remarks;

        // Load related data
        $this->customers = CustomerSupplier::all();
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->loadSubSegments();
    }

    public function updatedSegmentId($segmentId)
    {
        $this->segment_id = $segmentId;
        $this->loadSubSegments();
    }

    public function loadSubSegments()
    {
        // Load sub-segments based on the selected segment
        $this->subSegments = Segment::where('parent_id', $this->segment_id)->get();
    }

    public function save()
    {
        // Validate form data
        $this->validate();

        // Update lead details
        $this->lead->update([
            'customer_id' => $this->customer_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'expected_date' => $this->expected_date,
        ]);

        toastr()->closeButton(true)->success('Lead updated successfully.');
    }

    public function addRemark()
    {
        $this->validateRemark();

        // Create a new remark for the lead
        Remark::create([
            'lead_id' => $this->lead->id,
            'user_id' => Auth::id(),
            'remark' => $this->remark,
        ]);

        $this->refreshRemarks(); 
        $this->remark = ''; 
        session()->flash('message', 'Remark added successfully!');
    }

    protected function validateRemark()
    {
        $this->validate([
            'remark' => 'required|string|max:255',
        ]);
    }

    protected function refreshRemarks()
    {
        // Refresh the remarks list
        $this->remarks = $this->lead->remarks; 
    }

    public function render()
    {
        return view('livewire.crm.lead-edit');
    }
}
