<?php
namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\ExternalChalaan;
use App\Models\Product;
use App\Models\ChallanType;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Godown;
use App\Models\CustomerSupplier;
use Illuminate\Support\Facades\Auth;

class ExternalChalaanCreate extends Component
{
    public array $products = [];
    public $chalaanTypes;
    public $branches;
    public $customers;
    public array $availableProducts = [];
    public string $reference_id;
    public array $godowns = []; // Initialize godowns array

    public $chalaan_type_id;
    public $customer_id;

    protected $rules = [
        'chalaan_type_id' => 'required|exists:challan_types,id',
        'customer_id' => 'required|exists:customer_suppliers,id',
        'products.*.branch_id' => 'required|exists:branches,id',
        'products.*.godown_id' => 'required|exists:godowns,id',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.edit_quantity' => 'required|integer|min:1', // Add validation for edit_quantity
    ];

    public function mount()
    {
        $this->chalaanTypes = ChallanType::where('name', '!=', 'Branch Transfer')->get();
        $this->branches = Branch::all();
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->reference_id = 'EXT/' . str_pad(ExternalChalaan::count() + 1, 3, '0', STR_PAD_LEFT) . '/' . date('Y');
        $this->addProduct(); // Initialize with one product entry
    }

    public function addProduct()
    {
        $this->products[] = [
            'branch_id' => null,
            'godown_id' => null,
            'product_id' => null,
            'quantity' => null,
            'edit_quantity' => null, 
        ];
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products); // Re-index array
    }

    public function updated($propertyName)
    {
        // Update the godowns and available products when relevant properties change
        if (str_contains($propertyName, 'products.')) {
            preg_match('/products\.(\d+)\.(branch_id|godown_id|quantity|edit_quantity)/', $propertyName, $matches);
            if (isset($matches[1])) {
                $index = (int)$matches[1]; // Cast to integer

                if (strpos($propertyName, 'branch_id') !== false) {
                    $this->loadGodowns($index);
                    $this->products[$index]['godown_id'] = null; // Reset godown_id
                    $this->loadProducts($index); // Load products for the new godown
                }

                if (strpos($propertyName, 'godown_id') !== false) {
                    $this->loadProducts($index); // Load products based on the selected godown
                }

                // If quantity changes, also update edit_quantity
                if (strpos($propertyName, 'quantity') !== false) {
                    $this->products[$index]['edit_quantity'] = $this->products[$index]['quantity'];
                }
            }
        }
    }

    public function loadGodowns(int $index)
    {
        if (isset($this->products[$index]['branch_id']) && $this->products[$index]['branch_id']) {
            $this->godowns[$index] = Godown::where('branch_id', $this->products[$index]['branch_id'])->get();
        } else {
            $this->godowns[$index] = [];
        }
    }

    public function loadProducts(int $index)
    {
        if (isset($this->products[$index]['branch_id']) && isset($this->products[$index]['godown_id'])) {
            // Get stocks for the selected branch and godown
            $this->availableProducts[$index] = Product::whereHas('stock', function ($query) use ($index) {
                $query->where('branch_id', $this->products[$index]['branch_id'])
                    ->where('godown_id', $this->products[$index]['godown_id']);
            })->get();
        } else {
            $this->availableProducts[$index] = [];
        }
    }

    public function create()
    {
        $this->validate();
    
        // Check stock availability
        foreach ($this->products as $productData) {
            $productStock = Stock::where('product_id', $productData['product_id'])
                ->where('branch_id', $productData['branch_id'])
                ->where('godown_id', $productData['godown_id'])
                ->value('opening_stock');
    
            if (!$productStock || $productData['edit_quantity'] > $productStock) { // Use edit_quantity for validation
                $this->addError('products.' . $productData['product_id'] . '.edit_quantity', 'The quantity exceeds the available stock in the selected branch/godown.');
                return;
            }
        }
    
        // Create the external chalaan entry
        $chalaan = ExternalChalaan::create([
            'reference_id' => $this->reference_id,
            'chalaan_type_id' => $this->chalaan_type_id,
            'customer_id' => $this->customer_id,
            'created_by' => Auth::id(),
        ]);
    
        foreach ($this->products as $productData) {
            // Use updateOrCreate to manage the associated products for the external chalaan
            $chalaan->chalaanProducts()->updateOrCreate(
                [
                'product_id' => $productData['product_id'], 
                'branch_id' => $productData['branch_id'], 
                'godown_id' => $productData['godown_id'],
                'quantity' => $productData['quantity'],
                'edit_quantity' => $productData['quantity']
                ],
               
            );
    
            // Reduce stock from opening stock
            $stock = Stock::where('product_id', $productData['product_id'])
                ->where('branch_id', $productData['branch_id'])
                ->where('godown_id', $productData['godown_id'])
                ->first();
    
            if ($stock) {
                $stock->opening_stock -= $productData['edit_quantity'];
                $stock->save();
            }
        }
        toastr()->closeButton(true)->success('External Chalaan Created Successfully!');

        return redirect()->route('external.index');
    }
    
    public function render()
    {
        return view('livewire.crm.external-chalaan-create');
    }
}
