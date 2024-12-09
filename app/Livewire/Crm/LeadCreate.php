<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\LeadType;
use App\Models\Segment;
use App\Models\CustomerSupplier;
use App\Models\Series; 
use App\Models\Remark; 
use App\Models\StockCategory; 
use App\Models\ChildCategory; 
use App\Models\Contractor; 
use App\Models\Application; 

class LeadCreate extends Component
{
    public $customer_id;
    public $lead_status_id;
    public $lead_source_id;
    public $segment_id;
    public $sub_segment_id;
    public $expected_date;
    public $remark;
    public $category_id; // For stock category
    public $child_category_id; // For child category
    public $series; // Selected series
    public $lead_type_id; // For lead type
    public $amount; // Amount field
    public $specification; 
    public $referenceId;
    public $contractors = null; 
    public $contractor_ids = [];
    public $applications;
    public $application_id;
    public $showContractOptions = false; 

    public $leadStatuses;
    public $leadSources;
    public $leadTypes;
    public $segments;
    public $subSegments;
    public $customers;
    public $categories; // Stock categories
    public $childCategories; // Child categories
    public $seriesList; // List of series

    public function mount()
    {
        // Initialize dropdown values
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->subSegments = [];
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->categories = StockCategory::all();
        $this->childCategories = [];
        $this->seriesList = Series::all();
        $this->leadTypes = LeadType::all();
        $this->contractors = Contractor::all();
        $this->specification = null;
        $this->applications = Application::all(); 
        $this->referenceId = $this->generateReferenceId();
    }

    private function generateReferenceId()
    {
        // Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('M'); // e.g., Jan, Feb, etc.

        // Fetch the selected sub-segment abbreviation
        $subSegment = Segment::find($this->sub_segment_id);
        $subSegmentAbbreviation = $subSegment ? strtoupper(substr($subSegment->name, 0, 3)) : 'SSG'; 

        // Fetch the last lead with the matching pattern
        $lastLead = Lead::where('reference_id', 'like', "GTE/$currentYear/$currentMonth/%")
            ->orderBy('created_at', 'desc')
            ->first();

        // Determine the next number
        if ($lastLead) {
            $pattern = '/^GTE\/\d{4}\/[A-Za-z]+\/[A-Z0-9]+\/(\d{3})$/';
            if (preg_match($pattern, $lastLead->reference_id, $matches)) {
                $lastNumber = intval($matches[1]); 
                $number = $lastNumber + 1;        
            } else {
                $number = 1;
            }
        } else {
            $number = 1; 
        }

        // Format the number to three digits
        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

        // Return the formatted reference ID
        return sprintf('GTE/%d/%s/%s/%03d', $currentYear, $currentMonth, $subSegmentAbbreviation, $formattedNumber);
    }





    // Handle updates to category and child category selections
    public function updatedCategoryId($categoryId)
    {
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null;
        $this->seriesList = Series::where('stock_category_id', $categoryId)->get();
    }

    public function updatedChildCategoryId($childCategoryId)
    {
        $this->seriesList = Series::where('child_category_id', $childCategoryId)->get();
    }

    public function updatedSegmentId($segmentId)
    {
        $this->subSegments = Segment::where('parent_id', $segmentId)->get();
        $this->sub_segment_id = null;
    }

    public function updatedLeadTypeId($leadTypeId)
    {
        // Toggle visibility of contractor selection based on lead type
        $projectTypeId = LeadType::where('name', 'Project')->value('id');
        $this->showContractOptions = $leadTypeId == $projectTypeId;
    }

    public function submit()
    {
        // Validate form data
        $this->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'segment_id' => 'required|exists:segments,id',
            'sub_segment_id' => 'nullable|exists:segments,id',
            'expected_date' => 'required|date',
            'category_id' => 'nullable|exists:stock_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            'series' => 'required|exists:series,id',
            'remark' => 'nullable|string',
            'lead_type_id' => 'required|exists:lead_types,id',
            'amount' => 'nullable|numeric',
            'application_id' => 'required|exists:applications,id', 
            'specification' => 'nullable|in:favourable,non-favourable',
            'contractor_ids' => 'nullable|array',
            'contractor_ids.*' => 'exists:contractors,id',
        ]);

        // Generate reference ID
        $this->referenceId = $this->generateReferenceId();
        // Create the lead entry
        $lead = Lead::create([
            'customer_id' => $this->customer_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'expected_date' => $this->expected_date,
            'category_id' => $this->category_id,
            'child_category_id' => $this->child_category_id,
            'series' => $this->series,
            'lead_type_id' => $this->lead_type_id,
            'application_id' => $this->application_id,
            'contractor_ids' => $this->contractor_ids,
            'reference_id' => $this->referenceId,
            'amount' => $this->amount, 
            'specification' => $this->specification,
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
    
        toastr()->closeButton(true)->success('Lead added successfully.');
        return redirect()->route('leads.index');
    }

    public function render()
    {
        return view('livewire.crm.lead-create', [
            'leadStatuses' => $this->leadStatuses,
            'leadSources' => $this->leadSources,
            'segments' => $this->segments,
            'subSegments' => $this->subSegments,
            'customers' => $this->customers,
            'categories' => $this->categories,
            'childCategories' => $this->childCategories, 
            'seriesList' => $this->seriesList, 
            'leadTypes' => $this->leadTypes,
            'contractors' => $this->contractors,
        ]);
    }
}
