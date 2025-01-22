<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PurchaseOrder;
use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseOrderReport extends Component
{
    use WithPagination;

    public $search = '';
    public $teamFilter = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

    protected $queryString = ['search', 'teamFilter', 'statusFilter', 'startDate', 'endDate', 'perPage', 'sortBy', 'sortDir'];

    public function mount()
    {
        $this->search = session()->get('search', $this->search);
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'teamFilter', 'statusFilter', 'startDate', 'endDate']);
        $this->resetPage();
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
        $this->resetPage();
    }

    public function export($type)
    {
        $purchaseOrders = $this->filteredQuery()->get();

        $date = now()->format('Y_m_d');
        $fileName = "purchase_order_report_{$date}";

        if ($type === 'xlsx') {
            return Excel::download(new PurchaseOrderExport($purchaseOrders), "{$fileName}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new PurchaseOrderExport($purchaseOrders), "{$fileName}.csv");
        }

        return redirect()->route('purchase-order-reports.index');
    }

    public function filteredQuery()
    {
        return PurchaseOrder::query()
            ->when($this->search, function ($query) {
                $query->where('purchase_order_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('orderBranch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function render()
    {
        $purchaseOrder = $this->filteredQuery()->paginate($this->perPage);

        return view('livewire.reports.purchase-order-report', compact('purchaseOrder'));
    }
}
