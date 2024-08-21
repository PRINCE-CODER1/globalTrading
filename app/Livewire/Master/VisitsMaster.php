<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VisitMaster as Visits;

class VisitsMaster extends Component
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
        $visits = Visits::where('visitor_name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.visits-master', compact('visits'));
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
            $this->selectedVisits = Visits::pluck('id')->toArray();
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
            Visits::find($this->visitIdToDelete)->delete();
            $this->visitIdToDelete = null;
        } elseif (!empty($this->selectedVisits)) {
            Visits::whereIn('id', $this->selectedVisits)->delete();
            $this->selectedVisits = [];
        }
        toastr()->closeButton(true)->success('Visit Record Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedVisits)) {
            Visits::whereIn('id', $this->selectedVisits)->delete();
            $this->selectedVisits = [];
        }
        toastr()->closeButton(true)->success('Selected Visit Records Deleted Successfully');
        $this->resetPage();
    }
}
