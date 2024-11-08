<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeadType;
use Illuminate\Support\Facades\Session;

class LeadTypeList extends Component
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
            $this->selectedLeads = LeadType::pluck('id')->toArray();
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
            LeadType::find($this->leadIdToDelete)->delete();
            $this->leadIdToDelete = null;
        } elseif ($this->selectedLeads) {
            LeadType::whereIn('id', $this->selectedLeads)->delete();
            $this->selectedLeads = [];
        }
        
        toastr()->closeButton(true)->success('Lead Status deleted successfully.');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedLeads)) {
            LeadType::whereIn('id', $this->selectedLeads)->delete();
            $this->selectedLeads = [];
            toastr()->closeButton(true)->success('Selected Lead Type records deleted successfully.');
            $this->resetPage();
        }
    }
    public function render()
    {
        $leads = LeadType::query()
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->perPage);
        return view('livewire.master.lead-type-list',compact('leads'));
    }
}
