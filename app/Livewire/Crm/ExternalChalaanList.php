<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExternalChalaan; 
use App\Models\ExternalChalaanProduct;

class ExternalChalaanList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectedExternalChalaan = [];
    public $selectAll = false;
    public $deleteId;

    public $sortBy = 'created_at';
    public $sortDir = 'desc';

    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->sortBy = session()->get('sortBy', 'created_at');
        $this->sortDir = session()->get('sortDir', 'desc');
    }

    public function render()
    {
        $externalChalaans = ExternalChalaan::with(['chalaanProducts.products', 'customer', 'branch', 'godown']) // Load relationships correctly
                            ->where('reference_id', 'like', '%' . $this->search . '%')
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);

        return view('livewire.crm.external-chalaan-list');
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
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        $this->selectedExternalChalaan = $value 
            ? ExternalChalaan::pluck('id')->toArray() // Change to ExternalChalaan
            : [];
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->deleteId) {
            try {
                ExternalChalaan::findOrFail($this->deleteId)->delete(); // Change to ExternalChalaan
                toastr()->closeButton(true)->success('External Chalaan Deleted Successfully');
            } catch (\Exception $e) {
                toastr()->closeButton(true)->error('Error deleting External Chalaan: ' . $e->getMessage());
            } finally {
                $this->deleteId = null; // Clear the delete ID
                $this->resetPage();
            }
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedExternalChalaan)) {
            try {
                ExternalChalaan::whereIn('id', $this->selectedExternalChalaan)->delete(); // Change to ExternalChalaan
                toastr()->closeButton(true)->success('Selected External Chalaans Deleted Successfully');
            } catch (\Exception $e) {
                toastr()->closeButton(true)->error('Error deleting selected External Chalaans: ' . $e->getMessage());
            } finally {
                $this->selectedExternalChalaan = []; 
                $this->resetPage();
            }
        } else {
            toastr()->closeButton(true)->warning('No External Chalaans selected for deletion.');
        }
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
