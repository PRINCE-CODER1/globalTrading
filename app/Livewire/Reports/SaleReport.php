<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use App\Exports\SaleExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;  

class SaleReport extends Component
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
         $sale = Sale::query()
         ->when($this->search, function ($query) {
             $query->where('sale_no', 'like', '%' . $this->search . '%')
                 ->orWhereHas('customer', function ($subQuery) {
                     $subQuery->where('name', 'like', '%' . $this->search . '%');
                 })
                 ->orWhereHas('branch', function ($subQuery) {
                     $subQuery->where('name', 'like', '%' . $this->search . '%');
                 });
             })->get();
         $date = Carbon::now()->format('Y_m_d');
         if ($type == 'xlsx') {
             return Excel::download(new SaleExport($sale), "sale_report_{$date}.xlsx");
         } elseif ($type == 'csv') {
             return Excel::download(new SaleExport($sale), "sale_report_{$date}.csv");
         }
 
         return redirect()->route('sale-order-reports.index'); 
     }
    public function render()
    {
        $sale = Sale::query()
         ->when($this->search, function ($query) {
             $query->where('sale_no', 'like', '%' . $this->search . '%')
                 ->orWhereHas('customer', function ($subQuery) {
                     $subQuery->where('name', 'like', '%' . $this->search . '%');
                 })
                 ->orWhereHas('branch', function ($subQuery) {
                     $subQuery->where('name', 'like', '%' . $this->search . '%');
                 });
             })
             ->orderBy($this->sortBy, $this->sortDir)
             ->paginate($this->perPage);
        return view('livewire.reports.sale-report', compact('sale'));
    }
}
