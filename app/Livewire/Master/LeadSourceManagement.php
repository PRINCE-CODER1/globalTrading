<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeadSource;

class LeadSourceManagement extends Component
{
    use WithPagination;

    public $name;
    public $leadSourceId;
    public $editMode = false;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDir = 'asc';
    public $showForm = false;
    public $selectedLeadSources = [];
    public $showList = true; 
    public $selectAll = false;


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

    public function deleteSelected()
    {
        LeadSource::destroy($this->selectedLeadSources);
        $this->selectedLeadSources = [];
        session()->flash('message', 'Selected lead sources deleted successfully.');
    }
    public function updatedSearch($value)
    {
        session()->put('search', $value); 
    }
    public function toggleStatus($id)
    {
        $LeadSource = LeadSource::find($id);
        
        if ($LeadSource) {
            $LeadSource->active = !$LeadSource->active;
            $LeadSource->save();
            toastr()->closeButton(true)->success('Status updated successfully.');
        }
    }
    public function render()
    {
        $leadSources = LeadSource::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.master.lead-source-management', [
            'leadSources' => $leadSources,
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedLeadSources = LeadSource::pluck('id')->toArray();
        } else {
            $this->selectedLeadSources = [];
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedLeadSources)) {
            LeadSource::whereIn('id', $this->selectedLeadSources)->delete();
            $this->selectedLeadSources = [];
            toastr()->closeButton(true)->success('Selected lead sources deleted successfully.');
            $this->resetPage();
        }
    }

    public function confirmDelete($id)
    {
        $this->selectedLeadSources = [$id];
    }

    public function deleteConfirmed()
    {
        if (!empty($this->selectedLeadSources)) {
            LeadSource::destroy($this->selectedLeadSources);
            toastr()->closeButton(true)->success('Lead source deleted successfully.');
            $this->selectedLeadSources = [];
            $this->resetPage();
        }
    }
}
