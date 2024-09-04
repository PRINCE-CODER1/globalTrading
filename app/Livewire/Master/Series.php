<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Series as ser;
use Illuminate\Support\Facades\Auth;

class Series extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedSeries = [];
    public $seriesIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $series = ser::with('stockCategory','childCategory')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.series', compact('series'));
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
            $this->selectedSeries = ser::pluck('id')->toArray();
        } else {
            $this->selectedSeries = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->seriesIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->seriesIdToDelete) {
            ser::find($this->seriesIdToDelete)->delete();
            $this->seriesIdToDelete = null;
        } elseif ($this->selectedSeries) {
            ser::whereIn('id', $this->selectedSeries)->delete();
            $this->selectedSeries = [];
        }
        toastr()->closeButton(true)->success('Series Record Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedSeries)) {
            ser::whereIn('id', $this->selectedSeries)->delete();
            $this->selectedSeries = [];
        }
        toastr()->closeButton(true)->success('Selected Series Records Deleted Successfully');
        $this->resetPage();
    }
}
