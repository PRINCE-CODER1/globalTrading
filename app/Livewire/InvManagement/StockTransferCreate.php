<?php
namespace App\Livewire\InvManagement;

use Livewire\Component;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\StockTransfer;
use App\Models\MasterNumbering;

class StockTransferCreate extends Component
{
    public $stock_transfer_no;
    public $from_branch_id;
    public $stock_transfer_date;
    public $destination;
    public $dispatch_through;
    public $gr_no;
    public $gr_date;
    public $weight;
    public $no_of_boxes;
    public $vehicle_no;
    public $to_branch_id;
    public $to_godown_id;
    public $user_id;

    public $branches;
    public $godowns = [];

    public function mount()
    {
        $this->branches = Branch::all();
        $this->user_id = auth()->id();

        // Initialize the stock transfer number
        $this->generateStockTransferOrderNo();
    }

    public function updatedToBranchId($value)
    {
        // Load the Godowns based on the selected To Branch
        $this->godowns = Godown::where('branch_id', $value)->get();
        $this->to_godown_id = null;
    }

    public function generateStockTransferOrderNo()
    {
        // Fetch the last created stock transfer record
        $lastStockTransfer = StockTransfer::latest()->first();
        
        if ($lastStockTransfer) {
            // Extract the last number used
            preg_match('/(\d+)/', $lastStockTransfer->stock_transfer_no, $matches);
            $number = isset($matches[0]) ? intval($matches[0]) : 0;
            $number += 1;
        } else {
            // Start with 1 if no previous records exist
            $number = 1;
        }

        // Format the stock transfer number
        $this->stock_transfer_no = sprintf("ST/%03d/MO", $number);
    }

    public function save()
    {
        // Validate the form data
        $this->validate([
            'stock_transfer_no' => 'required|unique:stock_transfers,stock_transfer_no',
            'from_branch_id' => 'required|exists:branches,id',
            'stock_transfer_date' => 'required|date',
            'to_branch_id' => 'required|exists:branches,id',
            'to_godown_id' => 'required|exists:godowns,id',
        ]);

        // Create the stock transfer
        StockTransfer::create([
            'stock_transfer_no' => $this->stock_transfer_no,
            'from_branch_id' => $this->from_branch_id,
            'stock_transfer_date' => $this->stock_transfer_date,
            'destination' => $this->destination,
            'dispatch_through' => $this->dispatch_through,
            'gr_no' => $this->gr_no,
            'gr_date' => $this->gr_date,
            'weight' => $this->weight,
            'no_of_boxes' => $this->no_of_boxes,
            'vehicle_no' => $this->vehicle_no,
            'to_branch_id' => $this->to_branch_id,
            'to_godown_id' => $this->to_godown_id,
            'user_id' => $this->user_id,
        ]);

        // Show success message and redirect or reset form
        toastr()->closeButton(true)->success('Stock Transfer Created successfully.');
        return redirect()->route('stock_transfer.index');
    }

    public function render()
    {
        return view('livewire.inv-management.stock-transfer-create');
    }
}
