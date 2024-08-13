<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Session;

class LeadStatusList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedLeads = [];
    public $leadIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('leadStatusSearch', '');
        $this->perPage = session()->get('leadStatusPerPage', 10);
    }

    public function render()
    {
        $leads = LeadStatus::query()
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('status', 'like', "%{$this->search}%")
            ->paginate($this->perPage);

        return view('livewire.master.lead-status-list', compact('leads'));
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        session()->put('leadStatusPerPage', $this->perPage);
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        session()->put('leadStatusSearch', $value);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedLeads = LeadStatus::pluck('id')->toArray();
        } else {
            $this->selectedLeads = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->leadIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->leadIdToDelete) {
            LeadStatus::find($this->leadIdToDelete)->delete();
            $this->leadIdToDelete = null;
        } elseif ($this->selectedLeads) {
            LeadStatus::whereIn('id', $this->selectedLeads)->delete();
            $this->selectedLeads = [];
        }
        session()->flash('success', 'Lead Status deleted successfully.');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedLeads)) {
            LeadStatus::whereIn('id', $this->selectedLeads)->delete();
            $this->selectedLeads = [];
            session()->flash('success', 'Selected Lead Status records deleted successfully.');
            $this->resetPage();
        }
    }
}
