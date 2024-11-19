<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $selectedApplication = [];
    public $applicationIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'created_at');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function render()
    {
        $applications = Application::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);


        return view('livewire.master.application-list', compact('applications'));
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
            $this->selectedApplication = Application::pluck('id')->toArray();
        } else {
            $this->selectedApplication = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->applicationIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->applicationIdToDelete) {
            Application::find($this->applicationIdToDelete)->delete();
            $this->applicationIdToDelete = null;
        } elseif ($this->selectedApplication) {
            Application::whereIn('id', $this->selectedApplication)->delete();
            $this->selectedApplication = [];
        }
        toastr()->closeButton(true)->success('Application Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedApplication)) {
            Application::whereIn('id', $this->selectedApplication)->delete();
            $this->selectedApplication = [];
        }
        toastr()->closeButton(true)->success('Application Deleted Successfully');
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
