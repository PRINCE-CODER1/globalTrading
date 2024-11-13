<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contractor;

class ContractorList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $selectAll = false;
    public $selectedContractor = [];
    public $ContractorIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'name');
        // $this->sortDir = session()->get('sortDir', 'asc');
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
            $this->selectedContractor = Contractor::pluck('id')->toArray();
        } else {
            $this->selectedContractor = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->ContractorIdToDelete = $id; 
    }

    public function deleteConfirmed()
    {
        if ($this->ContractorIdToDelete) {
            Contractor::find($this->ContractorIdToDelete)->delete();
            $this->ContractorIdToDelete = null;
        } elseif (!empty($this->selectedContractor)) { // Correct variable name
            Contractor::whereIn('id', $this->selectedContractor)->delete();
            $this->selectedContractor = [];
        }
        toastr()->closeButton(true)->success('Contractors Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedContractor)) { // Correct variable name
            Contractor::whereIn('id', $this->selectedContractor)->delete();
            $this->selectedContractor = [];
        }
        toastr()->closeButton(true)->success('Contractors Deleted Successfully');
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

    public function render()
    {
        $contractors = Contractor::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.master.contractor-list', [
            'contractors' => $contractors,
        ]);
    }
}
