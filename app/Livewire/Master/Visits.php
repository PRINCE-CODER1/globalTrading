<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Visit;
use App\Models\Product;

class Visits extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedVisits = [];
    public $visitIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $visits = Visit::with(['product'])
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->orWhere('purpose', 'like', '%' . $this->search . '%')
            ->orderBy('visit_date', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.visits', compact('visits'));
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
            $this->selectedVisits = Visit::pluck('id')->toArray();
        } else {
            $this->selectedVisits = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->visitIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->visitIdToDelete) {
            Visit::find($this->visitIdToDelete)->delete();
            $this->visitIdToDelete = null;
        } elseif (!empty($this->selectedVisits)) {
            Visit::whereIn('id', $this->selectedVisits)->delete();
            $this->selectedVisits = [];
        }
        toastr()->closeButton(true)->success('Visit Record Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedVisits)) {
            Visit::whereIn('id', $this->selectedVisits)->delete();
            $this->selectedVisits = [];
        }
        toastr()->closeButton(true)->success('Selected Visit Records Deleted Successfully');
        $this->resetPage();
    }
}
