<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Purchase as Purchases;
use Illuminate\Support\Facades\Auth;

class Purchase extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedPurchases = [];
    public $purchaseIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $userId = Auth::id();

        $purchases = Purchases::with(['supplier', 'branch', 'purchaseOrder', 'user'])
            ->where('user_id', $userId)
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.inv-management.purchase', compact('purchases'));
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
            $this->selectedPurchases = Purchases::pluck('id')->toArray();
        } else {
            $this->selectedPurchases = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->purchaseIdToDelete = $id;
    }


    public function deleteConfirmed()
    {
        if ($this->purchaseIdToDelete) {
            Purchases::find($this->purchaseIdToDelete)->delete();
            toastr()->closeButton(true)->success('Purchase Deleted Successfully');
            $this->purchaseIdToDelete = null;
        }

        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedPurchases)) {
            Purchases::whereIn('id', $this->selectedPurchases)->delete();
            $this->selectedPurchases = [];
            toastr()->closeButton(true)->success('Purchases Deleted Successfully');
        }

        $this->resetPage();
    }


    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'asc';
        }
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
    }
}
