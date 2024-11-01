<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lead;
use App\Models\CustomerSupplier;
use App\Models\Segment;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Remark;
use App\Models\StockCategory;
use App\Models\ChildCategory;
use App\Models\Series;
use Illuminate\Support\Facades\Auth;

class LeadEdit extends Component
{
    use WithFileUploads;

    public $lead;
    public $series;
    public $seriesList;
    public $categories;
    public $childCategories = []; // Initialize as empty
    public $customer_id, $lead_status_id, $lead_source_id, $segment_id, $sub_segment_id, $expected_date, $remark, $image;
    public $customers, $leadStatuses, $leadSources, $segments, $subSegments, $remarks, $category_id, $child_category_id;

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'lead_status_id' => 'required|exists:lead_statuses,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'segment_id' => 'required|exists:segments,id',
        'sub_segment_id' => 'nullable|exists:segments,id',
        'category_id' => 'nullable|exists:stock_categories,id',
        'child_category_id' => 'nullable|exists:child_categories,id', // Ensure this points to the right table
        'series' => 'required|exists:series,id',
        'expected_date' => 'required|date',
        'remark' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:1024',
    ];

    public function mount($leadId)
    {
        $this->lead = Lead::findOrFail($leadId);
        $this->customer_id = $this->lead->customer_id;
        $this->lead_status_id = $this->lead->lead_status_id;
        $this->lead_source_id = $this->lead->lead_source_id;
        $this->segment_id = $this->lead->segment_id;
        $this->sub_segment_id = $this->lead->sub_segment_id;
        $this->category_id = $this->lead->category_id;
        $this->child_category_id = $this->lead->child_category_id;
        $this->series = $this->lead->series;
        $this->expected_date = $this->lead->expected_date;

        $this->remarks = $this->lead->remarks()->orderBy('created_at', 'desc')->get();
        $this->customers = CustomerSupplier::all();
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->categories = StockCategory::all();
        $this->seriesList = Series::all();
        
        $this->loadSubSegments();
    }

    public function updatedCategoryId($categoryId)
    {
        // Fetch child categories based on the selected stock category
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null; // Reset selected child category
    
        // Fetch series based on the selected stock category
        $this->seriesList = Series::where('stock_category_id', $categoryId)->get();
    }

    public function updatedSegmentId($segmentId)
    {
        $this->segment_id = $segmentId;
        $this->loadSubSegments();
    }

    public function loadSubSegments()
    {
        $this->subSegments = Segment::where('parent_id', $this->segment_id)->get();
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $fileName = uniqid() . '.' . $this->image->getClientOriginalExtension();
            $imagePath = $this->image->storeAs('remarks', $fileName, 'public');
        }

        $this->lead->update([
            'customer_id' => $this->customer_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'category_id' => $this->category_id,
            'child_category_id' => $this->child_category_id, // Added child category ID
            'series' => $this->series, 
            'expected_date' => $this->expected_date,
            'image' => $imagePath,
        ]);

        toastr()->closeButton(true)->success('Lead updated successfully.');
    }

    public function addRemark()
    {
        $this->validate([
            'remark' => 'required|string|max:255',
            'image' => 'nullable|image|max:1024',
        ]);

        $imagePath = null;
        if ($this->image) {
            $fileName = uniqid() . '.' . $this->image->getClientOriginalExtension();
            $imagePath = $this->image->storeAs('remarks', $fileName, 'public');
        }

        Remark::create([
            'lead_id' => $this->lead->id,
            'user_id' => Auth::id(),
            'remark' => $this->remark,
            'image' => $imagePath,
        ]);

        $this->refreshRemarks();
        $this->remark = '';
        $this->image = null;
        session()->flash('message', 'Remark added successfully!');
    }

    protected function refreshRemarks()
    {
        $this->remarks = $this->lead->remarks()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.crm.lead-edit');
    }
}
