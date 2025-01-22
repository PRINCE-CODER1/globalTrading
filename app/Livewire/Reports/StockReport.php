<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Exports\ProductStockExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StockReport extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = ['search', 'perPage', 'sortBy', 'sortDir', 'startDate', 'endDate'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'startDate', 'endDate']);
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
        $this->search = $value;
        session()->put('search', $this->search);
        $this->resetPage();
    }

    public function filteredQuery()
    {
        $userId = auth()->id();

        return Product::withCount([
            'purchase',
            'sale' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
        ->when($this->search, function ($query) {
            $query->where('product_name', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortBy, $this->sortDir);
    }

    public function export($type)
    {
        $products = $this->filteredQuery()->get();
        $date = Carbon::now()->format('Y_m_d');
        $fileName = "stock_report_{$date}";

        if ($type === 'xlsx') {
            return Excel::download(new ProductStockExport($products), "{$fileName}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new ProductStockExport($products), "{$fileName}.csv");
        }

        return redirect()->route('stock-reports.index');
    }

    public function render()
    {
        $productreport = $this->filteredQuery()->paginate($this->perPage);

        return view('livewire.reports.stock-report', compact('productreport'));
    }
}
