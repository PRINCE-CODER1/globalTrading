<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PurchaseOrder;
use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;  

class PurchaseOrderReport extends Component
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

    public function export($type)
    {
        $purchaseOrders = PurchaseOrder::query()
            ->when($this->search, function ($query) {
                $query->where('purchase_order_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('orderBranch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->get();

        $date = now()->format('Y_m_d');
        $fileName = "purchase_order_report_{$date}";

        if ($type === 'xlsx') {
            return Excel::download(new PurchaseOrderExport($purchaseOrders), "{$fileName}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new PurchaseOrderExport($purchaseOrders), "{$fileName}.csv");
        }

        return redirect()->route('purchase-order-reports.index');
    }

    public function render()
    {
        $purchaseOrder = PurchaseOrder::query()
            ->when($this->search, function ($query) {
                $query->where('purchase_order_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('orderBranch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.reports.purchase-order-report', compact('purchaseOrder'));
    }

}
