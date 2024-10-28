<?php 

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\ExternalChalaan;
use App\Models\Product;
use App\Models\ReturnChalaan;
use App\Models\ReturnChalaanProduct;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Godown;
use Illuminate\Support\Facades\Auth;

class ReturnChalaanCreate extends Component
{
    public $externalChalaanId;
    public $products = [];
    public $selectedProducts = [];
    public $returnReferenceId;
    public $returnedBy;
    public $branchId; 
    public $godownId; 
    public $godowns = [];

    public function mount()
    {
        $this->returnedBy = Auth::id(); 
        $this->generateReturnReferenceId();
        $this->godowns = []; 
    }

    public function updatedBranchId($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        $this->godownId = null;
    }

    public function updatedExternalChalaanId()
    {
        // Reset selected products whenever external chalaan changes
        $this->selectedProducts = [];
        
        // Get products associated with the selected external chalaan
        $this->products = ExternalChalaan::find($this->externalChalaanId)
            ->chalaanProducts()
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'name' => $item->product->product_name,
                    'quantity' => $item->quantity, 
                    'edit_quantity' => $item->quantity, 
                ];
            })
            ->toArray();
    }

    public function generateReturnReferenceId()
    {
        // Generate the return reference ID in the format RET/001/2024
        $count = ReturnChalaan::count() + 1; // Get the next count for the reference ID
        $year = date('Y');
        $this->returnReferenceId = sprintf('RET/%03d/%d', $count, $year);
    }

    public function save()
    {
        // Validate inputs
        $this->validate([
            'externalChalaanId' => 'required|exists:external_chalaans,id',
            'selectedProducts' => 'required|array',
            'selectedProducts.*.isSelected' => 'required|boolean',
            'selectedProducts.*.edit_quantity' => 'required|integer|min:1', // Validate edit_quantity
            'branchId' => 'required|exists:branches,id',
            'godownId' => 'required|exists:godowns,id',
        ]);

        // Create return chalaan record
        $returnChalaan = ReturnChalaan::create([
            'external_chalaan_id' => $this->externalChalaanId,
            'return_reference_id' => $this->returnReferenceId,
            'returned_by' => auth()->id(),
        ]);

        // Loop through selected products
        foreach ($this->selectedProducts as $productId => $selected) {
            if ($selected['isSelected']) { // Only save if the product is selected
                // Save return chalaan product
                ReturnChalaanProduct::create([
                    'return_chalaan_id' => $returnChalaan->id,
                    'product_id' => $productId,
                    'quantity_returned' => $selected['edit_quantity'], // Use edit_quantity here
                    'godown_id' => $this->godownId,
                    'branch_id' => $this->branchId,
                ]);

                // Retrieve the product with its associated stocks
                $product = Product::with('stock')->find($productId);

                // Update the product stock as already done
                if ($product) {
                    $stocks = $product->stock()->where('branch_id', $this->branchId)->where('godown_id', $this->godownId)->get();

                    if ($stocks && $stocks->isNotEmpty()) {
                        foreach ($stocks as $stock) {
                            $newOpeningStock = $stock->opening_stock + $selected['edit_quantity']; // Adjust using edit_quantity
                            $stock->update(['opening_stock' => $newOpeningStock]);
                        }
                    } else {
                        Stock::create([
                            'product_id' => $productId,
                            'opening_stock' => $selected['edit_quantity'],
                            'branch_id' => $this->branchId,
                            'godown_id' => $this->godownId,
                        ]);
                    }
                }

                // Now update the external chalaan product's quantity to reflect the return
                $chalaanProduct = ExternalChalaan::find($this->externalChalaanId)
                    ->chalaanProducts()
                    ->where('product_id', $productId)
                    ->first();

                if ($chalaanProduct) {
                    // Reduce the product quantity by the returned quantity
                    $newChalaanQuantity = $chalaanProduct->quantity - $selected['edit_quantity']; // Adjust using edit_quantity
                    $chalaanProduct->update(['quantity' => max(0, $newChalaanQuantity)]); // Ensure quantity does not go below 0
                }
            }
        }

        // Reset fields after saving
        $this->reset(['externalChalaanId', 'selectedProducts', 'branchId', 'godownId']);
        toastr()->closeButton(true)->success('Return Chalaan saved successfully!');
        return redirect()->route('return-chalaan.index');
    }

    public function render()
    {
        $externalChalaans = ExternalChalaan::all(); // Fetch external chalaans for selection
        $branches = Branch::all(); // Fetch branches for selection
        $godowns = Godown::all(); // Fetch godowns for selection
        return view('livewire.crm.return-chalaan-create', compact('externalChalaans', 'branches', 'godowns'));
    }
}
