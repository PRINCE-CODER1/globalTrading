<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Godown;
use App\Models\User;
use App\Models\Branch;

class Godowns extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedGodowns = [];
    public $godownIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function render()
    {
        $godowns = Godown::with(['user', 'branch'])
            ->where('godown_name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.godowns', compact('godowns'));
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedGodowns = Godown::pluck('id')->toArray();
        } else {
            $this->selectedGodowns = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->godownIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->godownIdToDelete) {
            Godown::find($this->godownIdToDelete)->delete();
            $this->godownIdToDelete = null;
        } elseif (!empty($this->selectedGodowns)) {
            Godown::whereIn('id', $this->selectedGodowns)->delete();
            $this->selectedGodowns = [];
        }
        toastr()->closeButton(true)->success('Godowns Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedGodowns)) {
            Godown::whereIn('id', $this->selectedGodowns)->delete();
            $this->selectedGodowns = [];
        }
        toastr()->closeButton(true)->success('Godowns Deleted Successfully');
        $this->resetPage();
    }
}
