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

class InternalChalaanEdit extends Component
{
    use WithPagination;

    public $chalaan_type_id, $reference_id, $internalChalaanId;
    public $products = [];
    public $branches = [];
    public $from_branch_id, $to_branch_id;
    public $from_godowns = [];
    public $to_godowns = [];
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

    public function mount($internalChalaanId)
    {
        $this->internalChalaanId = $internalChalaanId;
        $this->loadChalaanDetails();
        $this->chalaanTypes = ChallanType::where('name', 'Branch Transfer')->get();
        $this->branches = Branch::all();

        // Load existing chalaan details
        $this->loadChalaanDetails();
    }

    private function loadChalaanDetails()
    {
        // Ensure you're using findOrFail correctly
        $chalaan = InternalChalaan::with('products')->findOrFail($this->internalChalaanId);

        if ($chalaan) {
            $this->chalaan_type_id = $chalaan->chalaan_type_id;
            $this->reference_id = $chalaan->reference_id;
            $this->from_branch_id = $chalaan->from_branch_id;
            $this->to_branch_id = $chalaan->to_branch_id;

            // Load godowns for the respective branches
            $this->loadGodowns();

            // Load products related to this chalaan
            $this->products = $chalaan->products->map(function ($product) {
                // Ensure $product is indeed an instance of the Product model
                return [
                    'from_godown_id' => $product->from_godown_id,
                    'to_godown_id' => $product->to_godown_id,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity,
                ];
            })->toArray();
        }
    }



    private function loadGodowns()
    {
        // Load godowns based on selected branches
        $this->from_godowns = $this->from_branch_id ? Godown::where('branch_id', $this->from_branch_id)->get() : [];
        $this->to_godowns = $this->to_branch_id ? Godown::where('branch_id', $this->to_branch_id)->get() : [];
    }

    public function addProduct()
    {
        $this->products[] = ['from_godown_id' => null, 'to_godown_id' => null, 'product_id' => null, 'quantity' => 1];
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products); // Reindex the array
    }

    public function updatedFromBranchId()
    {
        $this->loadGodowns();
        $this->resetProductFromGodownIds();
    }

    public function updatedToBranchId()
    {
        $this->loadGodowns();
        $this->resetProductToGodownIds();
    }

    private function resetProductFromGodownIds()
    {
        foreach ($this->products as &$product) {
            $product['from_godown_id'] = null;
        }
    }

    private function resetProductToGodownIds()
    {
        foreach ($this->products as &$product) {
            $product['to_godown_id'] = null;
        }
    }

    public function updated($propertyName)
    {
        if (str_contains($propertyName, 'products')) {
            $index = explode('.', $propertyName)[1];
            $fromGodownId = $this->products[$index]['from_godown_id'];

            if ($fromGodownId) {
                $this->availableProducts[$index] = Stock::where('godown_id', $fromGodownId)
                    ->with('product')
                    ->get()
                    ->pluck('product');
            } else {
                $this->availableProducts[$index] = [];
                $this->products[$index]['product_id'] = null; 
            }
        }
    }

    public function update()
    {
        $this->validate();

        foreach ($this->products as $product) {
            $availableStock = $this->getAvailableStock($product['from_godown_id'], $product['product_id']);
            if ($product['quantity'] > $availableStock) {
                session()->flash('error', 'Insufficient stock for product ID: ' . $product['product_id']);
                return;
            }
        }

        DB::beginTransaction();

        try {
            $internalChalaan = InternalChalaan::findOrFail($this->internalChalaanId);
            $internalChalaan->update([
                'chalaan_type_id' => $this->chalaan_type_id,
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
            ]);

            // Delete existing products and recreate them
            $internalChalaan->products()->delete();

            foreach ($this->products as $product) {
                $internalChalaan->products()->create($product);

                // Update stock quantities
                $this->updateStock($product['from_godown_id'], $product['product_id'], -$product['quantity']);
                $this->updateStock($product['to_godown_id'], $product['product_id'], $product['quantity']);
            }

            DB::commit();
            toastr()->closeButton(true)->success('Internal Chalaan updated successfully.');
            return redirect()->route('internal.index'); 
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Internal Chalaan update failed:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to update Internal Chalaan. Please try again.');
        }
    }

    private function updateStock($godownId, $productId, $quantity)
    {
        $stock = Stock::where('product_id', $productId)
            ->where('godown_id', $godownId)
            ->first();

        if ($stock) {
            $newStock = $stock->opening_stock + $quantity;
            if ($newStock < 0) {
                throw new \Exception('Insufficient stock available for transfer.');
            }
            $stock->opening_stock = $newStock;
            $stock->save();
            Log::info('Stock updated:', ['product_id' => $productId, 'new_stock' => $newStock]);
        } else {
            Stock::create([
                'product_id' => $productId,
                'godown_id' => $godownId,
                'opening_stock' => $quantity,
                'branch_id' => $this->from_branch_id,
            ]);
        }
    }

    private function getAvailableStock($godownId, $productId)
    {
        $stock = Stock::where('product_id', $productId)
            ->where('godown_id', $godownId)
            ->first();

        return $stock ? $stock->opening_stock : 0; // Return available stock or 0 if not found
    }

    public function render()
    {
        return view('livewire.crm.internal-chalaan-edit', [
            'from_godowns' => $this->from_godowns,
            'to_godowns' => $this->to_godowns,
            'branches' => $this->branches,
            'availableProducts' => $this->availableProducts,
        ]);
    }
}
