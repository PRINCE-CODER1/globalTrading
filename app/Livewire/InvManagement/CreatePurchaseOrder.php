<?php


namespace App\Livewire\InvManagement;

use Livewire\Component;
use App\Models\Product;

class CreatePurchaseOrder extends Component
{
    public $products = [];
    public $allProducts;

    public function mount()
    {
        $this->allProducts = Product::all();
    }

    public function addProduct()
    {
        $this->products[] = [
            'product_id' => null,
            'expected_date' => null,
            'quantity' => null,
            'price' => null,
            'discount' => null,
            'sub_total' => null,
        ];
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function updated($propertyName)
    {
        $this->calculateSubTotals();
    }

    protected function calculateSubTotals()
    {
        foreach ($this->products as $index => &$product) {
            $quantity = $product['quantity'] ?? 0;
            $price = $product['price'] ?? 0;
            $discount = $product['discount'] ?? 0;

            // Calculate the subtotal only if quantity and price are provided
            if ($quantity && $price) {
                $subTotal = $quantity * $price * (1 - $discount / 100);
                $product['sub_total'] = number_format($subTotal, 2); // Format to 2 decimal places
            } else {
                $product['sub_total'] = '0.00'; // Default value if quantity or price is missing
            }
        }
    }

    public function render()
    {
        return view('livewire.inv-management.create-purchase-order');
    }
}
