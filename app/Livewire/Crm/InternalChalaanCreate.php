<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternalChalaan;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Godown;
use App\Models\ChallanType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InternalChalaanCreate extends Component
{
    use WithPagination;

    public $chalaan_type_id, $reference_id;
    public $products = [];
    public $branches = [];
    public $from_branch_id, $to_branch_id;
    public $from_godowns = []; // Godowns for the 'from' branch
    public $to_godowns = []; // Godowns for the 'to' branch
    public $availableProducts = [];
    public $chalaanTypes = [];

    protected $rules = [
        'chalaan_type_id' => 'required',
        'reference_id' => 'required',
        'from_branch_id' => 'required',
        'to_branch_id' => 'required',
        'products.*.from_godown_id' => 'required',
        'products.*.to_godown_id' => 'required',
        'products.*.product_id' => 'required',
        'products.*.quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->chalaanTypes = ChallanType::where('name', 'Branch Transfer')->get();
        $this->branches = Branch::all();
        $this->addProduct();

        // Set reference ID
        $this->reference_id = $this->generateReferenceId();
    }

    private function generateReferenceId()
    {
        $lastChalaan = InternalChalaan::orderBy('created_at', 'desc')->first();
        if ($lastChalaan && preg_match('/^INT\/(\d+)\/\d{4}$/', $lastChalaan->reference_id, $matches)) {
            $number = intval($matches[1]) + 1; // Increment the number part
        } else {
            $number = 1; // Start with 1 if no record exists
        }
        return sprintf('INT/%03d/%d', $number, date('Y')); // e.g., INT/002/2024
    }

    public function addProduct()
    {
        $this->products[] = ['from_godown_id' => null, 'to_godown_id' => null, 'product_id' => null, 'quantity' => 1];
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products); // Reset indexes
    }

    public function updatedFromBranchId()
    {
        // Update the available godowns based on the selected 'from' branch
        $this->from_godowns = Godown::where('branch_id', $this->from_branch_id)->get();
        // Reset the selected from_godown_id when the branch changes
        foreach ($this->products as &$product) {
            $product['from_godown_id'] = null; 
        }
    }

    public function updatedToBranchId()
    {
        // Update the available godowns based on the selected 'to' branch
        $this->to_godowns = Godown::where('branch_id', $this->to_branch_id)->get();
        // Reset the selected to_godown_id when the branch changes
        foreach ($this->products as &$product) {
            $product['to_godown_id'] = null; 
        }
    }

    public function updated($propertyName)
    {
        // Check if the updated property belongs to products
        if (str_contains($propertyName, 'products')) {
            $index = explode('.', $propertyName)[1];
            $fromGodownId = $this->products[$index]['from_godown_id'];

            if ($fromGodownId) {
                // Fetch available products based on the selected godown
                $this->availableProducts[$index] = Stock::where('godown_id', $fromGodownId)
                                                        ->with('product') // Load related product data
                                                        ->get()
                                                        ->pluck('product'); // Get the associated products
            } else {
                $this->availableProducts[$index] = [];
                $this->products[$index]['product_id'] = null; // Reset product ID
            }
        }
    }

    public function create()
    {
        // Validate the products array before proceeding
        foreach ($this->products as $index => $product) {
            $this->validate([
                "products.$index.from_godown_id" => 'required',
                "products.$index.to_godown_id" => 'required',
                "products.$index.product_id" => 'required',
                "products.$index.quantity" => 'required|integer|min:1',
            ]);

            // Check the available stock manually
            $availableStock = $this->getAvailableStock($product['from_godown_id'], $product['product_id']);
            if ($product['quantity'] > $availableStock) {
                toastr()->closeButton(true)->success('Return Chalaan saved successfully!'. $product['product_id']);
                // session()->flash('error', 'Insufficient stock for product ID: ' . $product['product_id']);
                return;
            }
        }

        // Start a transaction
        DB::beginTransaction();

        try {
            // Create new Internal Chalaan
            $internalChalaan = InternalChalaan::create([
                'reference_id' => $this->reference_id,
                'chalaan_type_id' => $this->chalaan_type_id,
                'created_by' => auth()->id(),
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
            ]);

            // Create Internal Chalaan Products and update stock
            foreach ($this->products as $product) {
                // Create the internal chalaan product entry
                $internalChalaanProduct = $internalChalaan->products()->create([
                    'from_godown_id' => $product['from_godown_id'],
                    'to_godown_id' => $product['to_godown_id'],
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'], // Save the input quantity directly
                ]);

                // Deduct stock from the from_godown
                $this->updateStock($product['from_godown_id'], $product['product_id'], -$product['quantity']);

                // Check if the product exists in the to_godown
                $this->updateStock($product['to_godown_id'], $product['product_id'], $product['quantity']);
            }

            // Commit the transaction
            DB::commit();

            toastr()->closeButton(true)->success('Internal Chalaan created successfully.');
            return redirect()->route('internal.index'); 
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Internal Chalaan creation failed:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to create Internal Chalaan. Please try again.');
        }
    }

    private function updateStock($godownId, $productId, $quantity)
    {
        // Fetch the stock entry from the Stock model
        $stock = Stock::where('product_id', $productId)
                       ->where('godown_id', $godownId)
                       ->first();

        if ($stock) {
            // Update stock by adding/subtracting the quantity
            $newStock = $stock->opening_stock + $quantity;
            
            if ($newStock < 0) {
                throw new \Exception('Insufficient stock available for transfer.');
            }

            // Save the updated stock
            $stock->opening_stock = $newStock;
            $stock->save();

            Log::info('Stock updated:', ['product_id' => $productId, 'new_stock' => $newStock]);
        } else {
            // If no stock entry exists, create a new one
            Stock::create([
                'product_id' => $productId,
                'godown_id' => $godownId,
                'opening_stock' => $quantity,
                'branch_id' => $this->from_branch_id, // Assuming branch is relevant here
            ]);
        }
    }

    private function getAvailableStock($godownId, $productId)
    {
        // Fetch the stock entry from the Stock model, which has the 'godown_id'
        $stock = Stock::where('product_id', $productId)
                       ->where('godown_id', $godownId)
                       ->first();

        return $stock ? $stock->opening_stock : 0; // Return stock if available, otherwise 0
    }

    public function render()
    {
        return view('livewire.crm.internal-chalaan-create', [
            'from_godowns' => $this->from_godowns,
            'to_godowns' => $this->to_godowns,
        ]);
    }
}
