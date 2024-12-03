<?php

namespace App\Livewire\Dar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dar;
use Illuminate\Support\Facades\Auth;

class DarList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $selectedDar = [];
    public $darIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $userId = Auth::id();
        $dar = Dar::with('customer')
            ->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->where('user_id', $userId)
            ->latest('created_at')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.dar.dar-list', compact('dar'));
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
            $this->selectedDar = Dar::pluck('dar_id')->toArray();
        } else {
            $this->selectedDar = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->darIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        $dar = Dar::find($this->darIdToDelete);
        if ($dar) {
            $dar->delete();
            toastr()->closeButton(true)->success('DAR deleted successfully.');
        }
        $this->darIdToDelete = null;
    }

    public function confirmBulkDelete()
    {
        // Check if any DARs are selected for deletion
        if (count($this->selectedDar) > 0) {
            // Proceed with the deletion
            Dar::whereIn('dar_id', $this->selectedDar)->delete();
            $this->selectedDar = []; // Reset selected DAR IDs
            toastr()->closeButton(true)->success('Selected DARs deleted successfully.');
        } else {
            // If no DARs are selected, show a warning
            toastr()->closeButton(true)->error( 'No DARs selected for deletion.');
        }
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
