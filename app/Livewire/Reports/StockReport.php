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
        $userId = auth()->id();
        $products = Product::with(['stock'])
            ->withCount([
                'purchase',
                'sale' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])
            ->when($this->search, function ($query) {
                $query->where('product_name', 'like', '%' . $this->search . '%');
            })
            ->get();
        $date = Carbon::now()->format('Y_m_d');
        if ($type == 'xlsx') {
            return Excel::download(new ProductStockExport($products), "stock_report_{$date}.xlsx");
        } elseif ($type == 'csv') {
            return Excel::download(new ProductStockExport($products), "stock_report_{$date}.csv");
        }

        return redirect()->route('stock-reports.index'); 
    }

    public function render()
    {
        $userId = auth()->id();

        // Filtered product report
        $productreport = Product::withCount([
            'purchase',
            'sale' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
        ->when($this->search, function ($query) {
            $query->where('product_name', 'like', '%' . $this->search . '%');
        })
        ->paginate($this->perPage);

        return view('livewire.reports.stock-report', compact('productreport'));
    }
}
