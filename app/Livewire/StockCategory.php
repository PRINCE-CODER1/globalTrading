<?php

namespace App\Http\Livewire;

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
    public $selectedCategoryIds = [];
    public $deleteId;

    protected $listeners = ['confirmDelete'];

    public function render()
    {
        $categories = StockCategory::with('parent')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.stock-category', compact('categories'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatePerPage($size)
    {
        $this->perPage = $size;
        $this->resetPage();
    }

    public function setSortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDir = 'asc';
        }
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
        session()->flash('success', 'Category deleted successfully.');
    }

    public function bulkDelete()
    {
        StockCategory::whereIn('id', $this->selectedCategoryIds)->delete();
        $this->selectedCategoryIds = [];
        session()->flash('success', 'Selected categories deleted successfully.');
    }
}
