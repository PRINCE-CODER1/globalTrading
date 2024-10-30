<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerSupplier;
use App\Models\User;

class CustSupp extends Component
{  
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $sortBy = 'name';
    public $sortDir = 'desc';
    public $selectedCustomerSuppliers = [];
    public $customerSupplierIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $customerSuppliers = CustomerSupplier::with('user')
            ->orderBy($this->sortBy, $this->sortDir)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('mobile_no', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.inv-management.cust-supp', compact('customerSuppliers'));
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        session()->put('perPage', $this->perPage);
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        session()->put('search', $value); 
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCustomerSuppliers = CustomerSupplier::pluck('id')->toArray();
        } else {
            $this->selectedCustomerSuppliers = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->customerSupplierIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->customerSupplierIdToDelete) {
            $customerSupplier = CustomerSupplier::find($this->customerSupplierIdToDelete);
            
            if ($customerSupplier) {
                // Check for related purchase orders
                if ($customerSupplier->purchaseOrders()->exists()) {
                    toastr()->closeButton(true)->error('Cannot delete this Customer/Supplier, it has related purchase orders.');
                    return;
                }

                $customerSupplier->delete();
                $this->customerSupplierIdToDelete = null;
                toastr()->closeButton(true)->success('Customer/Supplier Deleted Successfully');
            }
        } elseif (!empty($this->selectedCustomerSuppliers)) {
            foreach ($this->selectedCustomerSuppliers as $id) {
                $customerSupplier = CustomerSupplier::find($id);
                
                if ($customerSupplier) {
                    // Check for related purchase orders
                    if ($customerSupplier->purchaseOrders()->exists()) {
                        toastr()->closeButton(true)->error('Cannot delete Customer/Supplier with ID ' . $id . ', it has related purchase orders.');
                        continue; // Skip this supplier
                    }

                    $customerSupplier->delete();
                }
            }
            $this->selectedCustomerSuppliers = [];
            toastr()->closeButton(true)->success('Selected Customer/Suppliers Deleted Successfully');
        }

        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedCustomerSuppliers)) {
            foreach ($this->selectedCustomerSuppliers as $id) {
                $customerSupplier = CustomerSupplier::find($id);
                
                if ($customerSupplier) {
                    // Check for related purchase orders
                    if ($customerSupplier->purchaseOrders()->exists()) {
                        toastr()->closeButton(true)->error('Cannot delete Customer/Supplier with ID ' . $id . ', it has related purchase orders.');
                        continue; // Skip this supplier
                    }

                    $customerSupplier->delete();
                }
            }
            $this->selectedCustomerSuppliers = [];
            toastr()->closeButton(true)->success('Selected Customer/Suppliers Deleted Successfully');
        }

        $this->resetPage();
    }

    public function setSortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
    }
}
