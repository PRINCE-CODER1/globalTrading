<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SaleOrder;
use App\Exports\SaleOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SaleOrderReport extends Component
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
        return SaleOrder::query()
            ->when($this->search, function ($query) {
                $query->where('sale_order_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('orderBranch', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function export($type)
    {
        $saleOrders = $this->filteredQuery()->get();
        $date = Carbon::now()->format('Y_m_d');
        $fileName = "sale_order_report_{$date}";

        if ($type === 'xlsx') {
            return Excel::download(new SaleOrderExport($saleOrders), "{$fileName}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new SaleOrderExport($saleOrders), "{$fileName}.csv");
        }

        return redirect()->route('sale-order-reports.index');
    }

    public function render()
    {
        $saleOrder = $this->filteredQuery()->paginate($this->perPage);

        return view('livewire.reports.sale-order-report', compact('saleOrder'));
    }
}
