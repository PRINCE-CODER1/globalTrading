<?php
namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Segment;
use App\Models\CustomerSupplier;
use App\Models\Series; // Assuming 'Series' model is used
use App\Models\StockCategory; // Assuming 'StockCategory' model is used
use App\Models\ChildCategory; // Import the ChildCategory model

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

    public $leadStatuses;
    public $leadSources;
    public $segments;
    public $subSegments;
    public $customers;
    public $categories; // Stock categories
    public $childCategories; // Child categories
    public $seriesList; // List of series

    public function mount()
    {
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->subSegments = [];
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->categories = StockCategory::all(); // Fetch all stock categories
        $this->childCategories = [];
        $this->seriesList = Series::all(); // Fetch all series
    }

    public function updatedCategoryId($categoryId)
    {
        // Fetch child categories based on the selected stock category
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null;

        // Fetch series based on the selected stock category
        $this->seriesList = Series::where('stock_category_id', $categoryId)->get();
    }

    public function updatedChildCategoryId($childCategoryId)
    {
        // Filter series based on the selected child category
        $this->seriesList = Series::where('child_category_id', $childCategoryId)->get();
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
            'category_id' => 'nullable|exists:stock_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            'series' => 'required|exists:series,id',
            'remark' => 'nullable|string',
        ]);

        // Create the lead
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
            'assigned_to' => auth()->id(),
            'user_id' => auth()->id(),
        ]);

        

        toastr()->closeButton(true)->success('Lead added successfully.');
        return redirect()->route('agent.leads.index');
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
        ]);
    }
}
