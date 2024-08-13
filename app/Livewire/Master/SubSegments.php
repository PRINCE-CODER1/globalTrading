<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Segment;

class SubSegments extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $name;
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $active = true;
    public $parentId;
    public $subSegmentId; 
    public $isEditing = false;
    public $subSegmentIdToDelete;
    public $selectAll = false;
    public $selectedSegments = [];
    public $viewSubSegments = true; // Default to true to show list first
    public $parentSegments = []; // Used for dropdown in create/edit form

    protected $rules = [
        'name' => 'required|string|max:255',
        'active' => 'required|boolean',
        'parentId' => 'required|exists:segments,id',
    ];

    public function mount()
    {
        $this->parentSegments = Segment::whereNull('parent_id')->get(); 
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->active = true;
        $this->parentId = null;
        $this->subSegmentId = null;
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate();

        Segment::updateOrCreate(['id' => $this->subSegmentId], [
            'name' => $this->name,
            'active' => $this->active,
            'parent_id' => $this->parentId,
            'user_id' => Auth::id(),
        ]);

        $message = $this->subSegmentId ? 'Sub-segment updated successfully.' : 'Sub-segment created successfully.';
        toastr()->closeButton(true)->success($message);

        $this->resetInputFields();
        $this->viewSubSegments = true; // Switch back to list view
        $this->resetPage();
    }

    public function edit($id)
    {
        $subSegment = Segment::findOrFail($id);
        $this->subSegmentId = $id;
        $this->name = $subSegment->name;
        $this->active = $subSegment->active;
        $this->parentId = $subSegment->parent_id;
        $this->isEditing = true;
        $this->viewSubSegments = false; 
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSegments = Segment::pluck('id')->toArray();
        } else {
            $this->selectedSegments = [];
        }
    }

    public function bulkDelete()
    {
        Segment::whereIn('id', $this->selectedSegments)->delete();
        $this->selectedSegments = [];
        toastr()->closeButton(true)->success('Selected sub-segments deleted successfully.');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->subSegmentIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->subSegmentIdToDelete) {
            Segment::find($this->subSegmentIdToDelete)->delete();
            toastr()->closeButton(true)->success('Sub-segment deleted successfully.');
            $this->subSegmentIdToDelete = null;
            $this->resetPage();
        }
    }

    public function updatePerPage($count)
    {
        $this->perPage = $count;
        $this->resetPage();
    }

    public function backToCreate()
    {
        $this->resetInputFields();
        $this->viewSubSegments = false; 
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'asc';
        }
    }

    public function toggleView()
    {
        $this->viewSubSegments = !$this->viewSubSegments;
    }

    public function createSubSegment()
    {
        $this->resetInputFields();
        $this->viewSubSegments = false; 
    }

    public function toggleStatus($id)
    {
        $segment = Segment::find($id);
        
        if ($segment) {
            $segment->active = !$segment->active;
            $segment->save();
            toastr()->closeButton(true)->success('Status updated successfully.');
        }
    }

    public function render()
    {
        if ($this->viewSubSegments) {
            $segments = Segment::whereNotNull('parent_id')
                ->orderBy($this->sortBy, $this->sortDir)
                ->with('parent')
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate($this->perPage);
        } else {
            $segments = Segment::whereNull('parent_id')
                ->orderBy($this->sortBy, $this->sortDir)
                ->with('children')
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate($this->perPage);
        }

        return view('livewire.master.sub-segments', [
            'segments' => $segments,
            'parentSegments' => $this->parentSegments,
        ]);
    }
}
