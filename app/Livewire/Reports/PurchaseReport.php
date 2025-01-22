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

    protected $queryString = ['search', 'perPage', 'sortBy', 'sortDir'];

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

    public function filteredQuery()
    {
        return Purchase::query()
            ->with(['purchaseOrder', 'supplier', 'branch', 'items'])
            ->when($this->search, function ($query) {
                $query->whereHas('purchaseOrder', function ($subQuery) {
                    $subQuery->where('purchase_order_no', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('supplier', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function export($type)
    {
        $purchases = $this->filteredQuery()->get();

        if ($purchases->isEmpty()) {
            toastr()->closeButton(true)->error('No data found!');
            return;
        }

        $date = Carbon::now()->format('Y_m_d');
        $fileName = "purchase_report_{$date}";

        if ($type === 'xlsx') {
            return Excel::download(new PurchaseExport($purchases), "{$fileName}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new PurchaseExport($purchases), "{$fileName}.csv");
        }

        return redirect()->route('purchase-reports.index');
    }

    public function render()
    {
        $purchase = $this->filteredQuery()->paginate($this->perPage);

        return view('livewire.reports.purchase-report', compact('purchase'));
    }
}
