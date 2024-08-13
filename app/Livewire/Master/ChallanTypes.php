<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChallanType;

class ChallanTypes extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $selectAll = false;
    public $selectedChallanTypes = [];
    public $saleTypeIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'name');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function render()
    {
        $challanTypes = ChallanType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.master.challan-types',compact('challanTypes'));
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
            $this->selectedChallanTypes = ChallanType::pluck('id')->toArray();
        } else {
            $this->selectedChallanTypes = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->saleTypeIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->saleTypeIdToDelete) {
            ChallanType::find($this->saleTypeIdToDelete)->delete();
            $this->saleTypeIdToDelete = null;
        } elseif (!empty($this->selectedChallanTypes)) {
            ChallanType::whereIn('id', $this->selectedChallanTypes)->delete();
            $this->selectedChallanTypes = [];
        }
        toastr()->closeButton(true)->success('Sale Types Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedChallanTypes)) {
            ChallanType::whereIn('id', $this->selectedChallanTypes)->delete();
            $this->selectedChallanTypes = [];
        }
        toastr()->closeButton(true)->success('Sale Types Deleted Successfully');
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
