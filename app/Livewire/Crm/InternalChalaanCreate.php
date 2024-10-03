<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternalChalaan;
use App\Models\Product;
use App\Models\Branch;
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
    public $godowns = [];
    public $availableProducts = [];
    public $chalaanTypes = [];
    public $from_branch_id, $to_branch_id;

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
        $this->godowns = Godown::all();
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

    public function updated($propertyName)
    {
        // Check if the updated property belongs to products
        if (str_contains($propertyName, 'products')) {
            $index = explode('.', $propertyName)[1];
            $fromGodownId = $this->products[$index]['from_godown_id'];

            if ($fromGodownId) {
                // Fetch available products based on the selected godown
                $this->availableProducts[$index] = Product::where('godown_id', $fromGodownId)->get();
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
                session()->flash('error', 'Insufficient stock for product ID: ' . $product['product_id']);
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

            session()->flash('message', 'Internal Chalaan created successfully.');
            return redirect()->route('internal.index'); 
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();
            Log::error('Internal Chalaan creation failed:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to create Internal Chalaan. Please try again.');
        }
    }

    private function updateStock($godownId, $productId, $quantity)
    {
        // Fetch the product and update the stock based on the quantity
        $product = Product::where('id', $productId)->where('godown_id', $godownId)->first();

        if ($product) {
            $newStock = $product->opening_stock + $quantity; // Adjust the stock
            if ($newStock < 0) {
                // Handle insufficient stock
                throw new \Exception('Insufficient stock available for transfer.');
            }
            $product->update(['opening_stock' => $newStock]);
            // Debugging: Log the stock update
            Log::info('Stock updated:', ['product_id' => $productId, 'new_stock' => $newStock]);
        }
    }

    private function getAvailableStock($godownId, $productId)
    {
        // Fetch the available stock from the database
        $product = Product::where('id', $productId)->where('godown_id', $godownId)->first();

        return $product ? $product->opening_stock : 0; // Assuming 'opening_stock' is the column name in your products table
    }

    public function render()
    {
        return view('livewire.crm.internal-chalaan-create');
    }
}
