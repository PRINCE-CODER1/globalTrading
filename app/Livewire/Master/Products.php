<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedProducts = [];
    public $productIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $userId = Auth::id();

        $products = Product::with(['user', 'modifier', 'series', 'category'])
            // ->where('user_id', $userId)
            ->where('product_name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.master.products', compact('products'));
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
            $this->selectedProducts = Product::pluck('id')->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->productIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->productIdToDelete) {
            Product::find($this->productIdToDelete)->delete();
            $this->productIdToDelete = null;
        } elseif ($this->selectedProducts) {
            Product::whereIn('id', $this->selectedProducts)->delete();
            $this->selectedProducts = [];
        }
        toastr()->closeButton(true)->success('Product Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedProducts)) {
            Product::whereIn('id', $this->selectedProducts)->delete();
            $this->selectedProducts = [];
        }
        toastr()->closeButton(true)->success('Products Deleted Successfully');
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
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
    }
}
