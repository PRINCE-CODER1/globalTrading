<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lead;
use App\Models\LeadType;
use App\Models\CustomerSupplier;
use App\Models\CustomerSupplierUser;
use App\Models\Segment;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Remark;
use App\Models\StockCategory;
use App\Models\ChildCategory;
use App\Models\Contractor;
use App\Models\Application;
use App\Models\Series;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeadEdit extends Component
{
    use WithFileUploads;

    public $lead;
    public $series;
    public $seriesList;
    public $categories;
    public $lead_type_id;
    public $amount; 
    public $specification;
    public $applications;
    public $application_id;
    public $date;

    public $customer_supplier_user_id = null;
    public $selectedCustomerUsers = [];

    public $contractor_ids = [];
    public $contractors = [];
    public $showContractOptions = false; 

    public $leadTypes;
    public $assigned_to; 
    public $teamAgents = [];
    public $childCategories = []; // Initialize as empty
    public $customer_id, $lead_status_id, $lead_source_id, $segment_id, $sub_segment_id, $expected_date, $remark, $image;
    public $customers, $leadStatuses, $leadSources, $segments, $subSegments, $remarks, $category_id, $child_category_id;

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'customer_supplier_user_id' => 'nullable|exists:customer_supplier_users,id',
        'lead_status_id' => 'required|exists:lead_statuses,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'segment_id' => 'required|exists:segments,id',
        'sub_segment_id' => 'nullable|exists:segments,id',
        'category_id' => 'nullable|exists:stock_categories,id',
        'child_category_id' => 'nullable|exists:child_categories,id',
        'series' => 'required|exists:series,id',
        'expected_date' => 'required|date',
        'remark' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
        'lead_type_id' => 'required|exists:lead_types,id',
        'amount' => 'nullable|numeric',
        'specification' => 'nullable|in:favourable,non-favourable',
        'assigned_to' => 'nullable|exists:users,id',
        'contractor_ids' => 'nullable|array',
        'contractor_ids.*' => 'exists:contractors,id',
        'application_id' => 'required|exists:applications,id',
    ];
    
    public function mount($leadId)
    {
        $this->lead = Lead::findOrFail($leadId);


        // Bind other fields...
        $this->assigned_to = $this->lead->assigned_to ?? auth()->id();
        $this->customer_id = $this->lead->customer_id;
        $this->customer_supplier_user_id = $this->lead->customer_supplier_user_id;
        $this->selectedCustomerUsers = CustomerSupplierUser::where('customer_supplier_id', $this->customer_id)->get();
        $this->lead_status_id = $this->lead->lead_status_id;
        $this->lead_source_id = $this->lead->lead_source_id;
        $this->lead_type_id = $this->lead->lead_type_id;
        $this->segment_id = $this->lead->segment_id;
        $this->sub_segment_id = $this->lead->sub_segment_id;
        $this->category_id = $this->lead->category_id;
        $this->child_category_id = $this->lead->child_category_id;
        $this->series = $this->lead->series;
        $this->expected_date = $this->lead->expected_date;
        $this->amount = $this->lead->amount;
        $this->specification = $this->lead->specification;
        $this->application_id = $this->lead->application_id;

        // Set the flag for showing contractor options based on the lead type
        $this->showContractOptions = $this->lead_type_id == LeadType::where('name', 'Project')->value('id');

        // Load contractors and other options
        $this->applications = Application::all();
        $this->contractors = Contractor::all();
        $this->remarks = $this->lead->remarks()->orderBy('created_at', 'desc')->get();
        $this->customers = CustomerSupplier::all();
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->categories = StockCategory::all();
        $this->seriesList = Series::all();
        $this->leadTypes = LeadType::all();
        $this->contractors = Contractor::all();
        $this->contractor_ids = is_array($this->lead->contractor_ids) ? $this->lead->contractor_ids : explode(',', $this->lead->contractor_ids);
      
        // Load sub-segments and categories
        $this->loadSubSegments();
        if ($this->category_id) {
            $this->childCategories = ChildCategory::where('parent_category_id', $this->category_id)->get();
        }

        
        $this->teamAgents = User::all();

    }
    public function addContractor()
    {
        $this->contractor_ids[] = null; 
    }

    public function removeContractor($index)
    {
        unset($this->contractor_ids[$index]);
        $this->contractor_ids = array_values($this->contractor_ids); 
    }
    public function selectContractor($contractorId, $index)
    {
        $this->contractor_ids[$index] = $contractorId;
    }

    public function updatedCustomerId($customerId)
    {
        $this->selectedCustomerUsers = CustomerSupplierUser::where('customer_supplier_id', $customerId)->get();
        $this->customer_supplier_user_id = null;  
    }

    public function updatedLeadTypeId($leadTypeId)
    {
        $projectTypeId = LeadType::where('name', 'Project')->value('id');
        $this->showContractOptions = $leadTypeId == $projectTypeId;

        $this->contractor_id = null;
    }


    public function updatedCategoryId($categoryId)
    {
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null;
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

        // Handle image upload if exists
        $imagePath = $this->lead->image; // Retain the existing image if no new one is uploaded
        if ($this->image) {
            $fileName = uniqid() . '.' . $this->image->getClientOriginalExtension();
            $imagePath = $this->image->storeAs('remarks', $fileName, 'public');
        }

        // Update the lead
        $this->lead->update([
            'customer_id' => $this->customer_id,
            'customer_supplier_user_id' => $this->customer_supplier_user_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'category_id' => $this->category_id,
            'child_category_id' => $this->child_category_id,
            'series' => $this->series,
            'expected_date' => $this->expected_date,
            'lead_type_id' => $this->lead_type_id,
            'contractor_ids' => implode(',', $this->contractor_ids),
            'image' => $imagePath,
            'amount' => $this->amount,
            'application_id' => $this->application_id,
            'specification' => $this->specification,
            'assigned_to' => $this->assigned_to,
        ]);

        // Update the Livewire component values with the saved values
        $this->contractor_ids = is_array($this->lead->contractor_ids) ? $this->lead->contractor_ids : explode(',', $this->lead->contractor_ids);

        $this->assignAgent();
    }



    public function assignAgent()
    {
        if ($this->assigned_to === null) {
            toastr()->error('Please assign an agent.');
            return;
        }

        $this->validate(['assigned_to' => 'required']);

        // Update the lead with the new assigned agent
        $this->lead->update(['assigned_to' => $this->assigned_to]);

        // Update the visibility logic
        $agentName = User::find($this->assigned_to)->name;
        toastr()->closeButton(true)->success("Successfully assigned to $agentName");

        // Update the Livewire component values with the saved values
        // $this->assigned_to = null;
        // $this->reset(['assigned_to']);
    }



    public function addRemark()
    {
        $this->validate([
            'remark' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'date' => 'nullable|date',
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
            'date' => $this->date,
        ]);

        $this->refreshRemarks();
        $this->remark = '';
        $this->image = null;
        $this->date = null;
        session()->flash('message', 'Remark added successfully!');
    }

    protected function refreshRemarks()
    {
        $this->remarks = $this->lead->remarks()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.crm.lead-edit', [
            'leadTypes' => $this->leadTypes,
            'contractors' => $this->contractors,
        ]);
    }
}