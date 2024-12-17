<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\LeadType;
use App\Models\Segment;
use App\Models\CustomerSupplier;
use App\Models\CustomerSupplierUser;
use App\Models\Series; 
use App\Models\Remark; 
use App\Models\StockCategory; 
use App\Models\ChildCategory; 
use App\Models\Contractor; 
use App\Models\Application; 

class LeadCreate extends Component
{
    public $search = '';
    public $customer_id = null;
    public $showDropdown = false;
    public $allCustomer = [];

    public $customerUsers = [];
    public $selectedCustomerUsers = [];
    public $customer_supplier_user_id;

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

    public $testVar;
    public $filteredCustomers;
    public $selectedCustomer = null; 

    public function mount()
    {
        // Initialize dropdown values
        $this->leadStatuses = LeadStatus::all();
        $this->leadSources = LeadSource::all();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->subSegments = [];
        $this->fetchAllCustomers();
        $this->categories = StockCategory::all();
        $this->childCategories = [];
        $this->seriesList = Series::all();
        $this->leadTypes = LeadType::all();
        $this->contractors = Contractor::all();
        $this->specification = null;
        $this->applications = Application::all(); 
        $this->referenceId = $this->generateReferenceId();
    }
    

    public function fetchAllCustomers()
    {
        $this->allCustomer = CustomerSupplier::all();
        $this->filteredCustomers = $this->allCustomer;
    }


    public function updatedSearch()
    {
        $this->filteredCustomers = collect($this->allCustomer)->filter(function ($customer) {
            return str_contains(strtolower($customer['name']), strtolower($this->search));
        })->toArray();
    }

    // public function selectCustomer($customerId)
    // {
    //     $this->selectedCustomer = collect($this->allCustomer)->firstWhere('id', $customerId);
    //     $this->customer_id = $customerId; 

    //     $this->search = $this->selectedCustomer['name'];

    //     $this->filteredCustomers = [];
    // }
    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = collect($this->allCustomer)->firstWhere('id', $customerId);
        $this->customer_id = $customerId;
        $this->search = $this->selectedCustomer['name'];

        // Fetch customer users
        $this->selectedCustomerUsers = CustomerSupplierUser::where('customer_supplier_id', $customerId)->get();

        $this->customer_supplier_user_id = null; // Reset selected user
        $this->filteredCustomers = [];
    }

    public function showDropdown()
    {
        if (empty($this->search)) {
            $this->fetchAllCustomers(); 
        }
        $this->showDropdown = true;
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function keepDropdownOpen()
    {
        $this->showDropdown = true;
    }

    public function selectCustomer1($customerId)
    {
        $this->search = CustomerSupplier::find($customerId)?->name ?? '';
         
        $this->testVar = $customerId; 
    }
    private function generateReferenceId() 
    {
        $currentYear = date('Y');
        $currentMonth = date('M');

        // Fetch the selected sub-segment abbreviation (if needed, but not for number calculation)
        $subSegment = Segment::find($this->sub_segment_id); // Assuming this is the ID of the sub-segment you just saved
        $subSegmentAbbreviation = $subSegment ? $subSegment->abbreviation : 'SSG';

        // Find the last lead to determine the next reference number (ignore sub-segment for number incrementation)
        $lastLead = Lead::where('reference_id', 'like', "GTE/$currentYear/%")
            ->orderBy('created_at', 'desc')
            ->first();

        // Increment the number or start at 1 if no previous leads exist
        if ($lastLead) {
            $lastNumber = (int) substr($lastLead->reference_id, -3); // Extract the last 3 digits as the number
            $number = $lastNumber + 1;
        } else {
            $number = 1; // Start from 1 if no leads exist
        }

        // Format the number to be 3 digits
        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

        // Return the formatted reference ID using the current year, sub-segment abbreviation, and incremented number
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
            'customer_supplier_user_id' => 'required',
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

        if ($this->expected_date) {
            $this->expected_date = $this->expected_date . '-01';
        }

        // Generate reference ID
        $this->referenceId = $this->generateReferenceId();

        // Create the lead entry
        $lead = Lead::create([
            'customer_id' => $this->customer_id,
            'customer_supplier_user_id' => $this->customer_supplier_user_id,
            'lead_status_id' => $this->lead_status_id,
            'lead_source_id' => $this->lead_source_id,
            'segment_id' => $this->segment_id,
            'sub_segment_id' => $this->sub_segment_id,
            'expected_date' => $this->expected_date, // Store the corrected expected date
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
            'selectedCustomerUsers' => $this->selectedCustomerUsers,
        ]);
    }
}