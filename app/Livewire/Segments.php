<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Segment;

class Segments extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $name;
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $active = true;
    public $parentId;
    public $selectAll = false;
    public $selectedSegments = [];
    public $segmentId; 
    public $viewSegments = true; 
    public $isEditing = false; 
    public $segmentIdToDelete;
    public $parentSegments = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'active' => 'required|boolean',
        'parentId' => 'nullable|exists:segments,id',
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
        $this->segmentId = null;
        $this->isEditing = false; // Reset editing status
    }

    public function store()
    {
        $this->validate();

        Segment::updateOrCreate(['id' => $this->segmentId], [
            'name' => $this->name,
            'active' => $this->active,
            'parent_id' => $this->parentId,
        ]);

        $message = $this->segmentId ? 'Segment updated successfully.' : 'Segment created successfully.';
        toastr()->closeButton(true)->success($message);

        $this->resetInputFields();
        $this->viewSegments = true; 
        $this->resetPage();
    }

    public function edit($id)
    {
        $segment = Segment::findOrFail($id);
        $this->segmentId = $id;
        $this->name = $segment->name;
        $this->active = $segment->active;
        $this->parentId = $segment->parent_id;
        $this->isEditing = true;
        $this->viewSegments = false;
    }

    public function createSegment()
    {
        $this->resetInputFields();
        $this->viewSegments = false; 
    }

    public function toggleView()
    {
        $this->viewSegments = !$this->viewSegments;
        if ($this->viewSegments) {
            $this->resetInputFields();
        }
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
        toastr()->closeButton(true)->success('Selected segments deleted successfully.');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->segmentIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->segmentIdToDelete) {
            Segment::findOrFail($this->segmentIdToDelete)->delete();
            toastr()->closeButton(true)->success('Segment deleted successfully.');
            $this->segmentIdToDelete = null;
            $this->resetPage();
        }
    }

    public function updatePerPage($count)
    {
        $this->perPage = $count;
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
    }

    public function render()
    {
        $segments = Segment::whereNull('parent_id') 
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->where('name', 'like', '%' . $this->search . '%')
                            ->paginate($this->perPage);

        return view('livewire.segments', [
            'segments' => $segments,
        ]);
    }
}
