<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternalChalaan;

class InternalChalaanList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectedInternalChalaan = [];
    public $selectAll = false;
    public $deleteId;

    public $sortBy = 'created_at';
    public $sortDir = 'desc';

    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $internalChalaans = InternalChalaan::where('reference_id', 'like', '%' . $this->search . '%')
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);
        
        return view('livewire.crm.internal-chalaan-list', compact('internalChalaans'));
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
        $this->selectedInternalChalaan = $value 
            ? InternalChalaan::pluck('id')->toArray() 
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
                $internalChalaan = InternalChalaan::find($this->deleteId);
                if ($internalChalaan) {
                    $internalChalaan->delete();
                    toastr()->closeButton(true)->success('Internal Chalaan Deleted Successfully');
                }
            } catch (\Exception $e) {
                toastr()->closeButton(true)->error('Error deleting Internal Chalaan: ' . $e->getMessage());
            } finally {
                $this->deleteId = null; 
                $this->resetPage();
            }
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedInternalChalaan)) {
            try {
                InternalChalaan::whereIn('id', $this->selectedInternalChalaan)->delete();
                toastr()->closeButton(true)->success('Selected Internal Chalaans Deleted Successfully');
            } catch (\Exception $e) {
                toastr()->closeButton(true)->error('Error deleting selected Internal Chalaans: ' . $e->getMessage());
            } finally {
                $this->selectedInternalChalaan = []; 
                $this->resetPage();
            }
        } else {
            toastr()->closeButton(true)->warning('No Internal Chalaans selected for deletion.');
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
