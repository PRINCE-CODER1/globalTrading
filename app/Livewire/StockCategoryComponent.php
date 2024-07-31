<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockCategory;

class StockCategoryComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDir = 'asc';
    public $selectAll = false;
    public $selectedCategoryIds = [];
    public $deleteId;

    protected $listeners = ['confirmDelete'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->sortBy = session()->get('sortBy', 'name');
        $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function render()
    {
        $categories = StockCategory::with('parent')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.stock-category-component', compact('categories'));
    }

    public function updatedSearch($value)
    {
        session()->put('search', $value);
        $this->resetPage();
    }

    public function updatePerPage($size)
    {
        $this->perPage = $size;
        session()->put('perPage', $this->perPage);
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCategoryIds = StockCategory::pluck('id')->toArray();
        } else {
            $this->selectedCategoryIds = [];
        }
    }

    public function setSortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDir = 'asc';
        }
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteConfirmed()
    {
        StockCategory::find($this->deleteId)->delete();
        $this->reset(['deleteId']);
        toastr()->closeButton(true)->success('Deleted successfully.');
    }

    public function bulkDelete()
    {
        StockCategory::whereIn('id', $this->selectedCategoryIds)->delete();
        $this->selectedCategoryIds = [];
        toastr()->closeButton(true)->success('Deleted successfully.');
    }
}
