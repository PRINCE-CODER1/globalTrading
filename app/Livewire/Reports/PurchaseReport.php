<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Purchase;
use App\Exports\PurchaseExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;  

class PurchaseReport extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        session()->put('perPage', $this->perPage);
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        $this->search = $value;
        session()->put('search', $this->search);
        $this->resetPage();
    }
    // Export method that handles download
    public function export($type)
    {
        $purchase = Purchase::query()
            ->when($this->search, function ($query) {
                $query->where('purchase_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('branch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })->get();

        $date = Carbon::now()->format('Y_m_d');

        if ($type == 'xlsx') {
            return Excel::download(new PurchaseExport($purchase), "purchase_report_{$date}.xlsx");
        } elseif ($type == 'csv') {
            return Excel::download(new PurchaseExport($purchase), "purchase_report_{$date}.csv");
        }

        return redirect()->route('purchase-reports.index');
    }

    public function render()
    {
        $purchase = Purchase::query()
            ->when($this->search, function ($query) {
                $query->where('purchase_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('branch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.reports.purchase-report', compact('purchase'));
    }
}
