<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lead;

class LeadList extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];

    public function render()
    {
        $leads = Lead::where('customer_id', 'like', '%'.$this->search.'%')
                    ->orWhere('lead_status_id', 'like', '%'.$this->search.'%')
                    ->paginate(10);

        return view('livewire.crm.lead-list', compact('leads'));
    }

    public function delete($leadId)
    {
        Lead::find($leadId)->delete();
        session()->flash('success', 'Lead deleted successfully.');
    }
}
