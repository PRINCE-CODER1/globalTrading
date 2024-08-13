<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Workshop;
use App\Models\Branch;

class WorkshopManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedWorkshops = [];
    public $workshopIdToDelete = null;

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
        $workshops = Workshop::with('branch')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereRelation('branch','name', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.master.workshop-management', [
            'workshops' => $workshops,
        ]);
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
            $this->selectedWorkshops = Workshop::pluck('id')->toArray();
        } else {
            $this->selectedWorkshops = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->workshopIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->workshopIdToDelete) {
            Workshop::find($this->workshopIdToDelete)->delete();
            $this->workshopIdToDelete = null;
        } elseif ($this->selectedWorkshops) {
            Workshop::whereIn('id', $this->selectedWorkshops)->delete();
            $this->selectedWorkshops = [];
        }
        toastr()->closeButton(true)->success('Workshop Deleted successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedWorkshops)) {
            Workshop::whereIn('id', $this->selectedWorkshops)->delete();
            $this->selectedWorkshops = [];
        }
        toastr()->closeButton(true)->success('Workshops Deleted successfully');
        $this->resetPage();
    }
}

