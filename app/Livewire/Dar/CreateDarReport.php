<?php

namespace App\Livewire\Dar;

use Livewire\Component;
use App\Models\Dar;
use App\Models\CustomerSupplier;
use App\Models\CustomerSupplierUser;
use App\Models\VisitMaster;
use Illuminate\Support\Facades\Auth;

class CreateDarReport extends Component
{
    public $customers = [];
    public $purposes = [];
    public $customer_id;
    public $pov_id;
    public $remarks;
    public $status = 0;
    public $rating;
    public $date;
    public $user_id;

    public $customer_supplier_user_id = null;
    public $selectedCustomerUsers = [];

    public $search = '';
    public $filteredCustomers = [];
    public $allCustomer = [];
    public $selectedCustomer;
    public $showDropdown = false;

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'pov_id' => 'required|exists:visit_masters,id',
        'remarks' => 'nullable|string',
        'status' => 'required|in:0,1',
        'rating' => 'nullable|integer|between:1,5',
        'date' => 'required|date',
        'customer_supplier_user_id' => 'nullable|exists:customer_supplier_users,id',
    ];

    public function mount()
    {
        $this->customers = CustomerSupplier::all();
        $this->purposes = VisitMaster::all();
        $this->user_id = Auth::id();
        $this->fetchAllCustomers();
    }

    public function fetchAllCustomers()
    {
        $this->allCustomer = CustomerSupplier::all();
        $this->filteredCustomers = $this->allCustomer->toArray();
    }

    /**
     * Filters customers based on the search term.
     */
    public function updatedSearch()
    {
        $this->filteredCustomers = collect($this->allCustomer)->filter(function ($customer) {
            return str_contains(strtolower($customer['name']), strtolower($this->search));
        })->toArray();

        $this->showDropdown = !empty($this->filteredCustomers);
    }

    /**
     * Selects a customer from the dropdown and fetches related users.
     */
    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = collect($this->allCustomer)->firstWhere('id', $customerId);
        $this->customer_id = $customerId;
        $this->search = $this->selectedCustomer['name'];

        // Fetch related users
        $this->selectedCustomerUsers = CustomerSupplierUser::where('customer_supplier_id', $customerId)->get();
        $this->customer_supplier_user_id = null; // Reset selected user dropdown

        $this->filteredCustomers = [];
        $this->showDropdown = false;
    }

    /**
     * Shows the dropdown when input is focused.
     */
    public function showDropdown()
    {
        if (empty($this->search)) {
            $this->fetchAllCustomers();
        }
        $this->showDropdown = true;
    }

    /**
     * Hides the dropdown when input loses focus.
     */
    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    /**
     * Submits the form after validation.
     */
    public function submit()
    {
        $this->validate();

        Dar::create([
            'customer_id' => $this->customer_id,
            'pov_id' => $this->pov_id,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'rating' => $this->rating,
            'date' => $this->date,
            'user_id' => $this->user_id,
            'customer_supplier_user_id' => $this->customer_supplier_user_id,
        ]);

        toastr()->closeButton(true)->success('DAR form created successfully!');
        return redirect()->route('daily-report.index');
    }

    /**
     * Renders the component view.
     */
    public function render()
    {
        return view('livewire.dar.create-dar-report');
    }
}
