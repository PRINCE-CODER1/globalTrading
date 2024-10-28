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
use Illuminate\Support\Facades\DB;

class ReturnChalaanEdit extends Component
{
    public $returnChalaanId;
    public $externalChalaanId;
    public $products = [];
    public $selectedProducts = [];
    public $returnReferenceId;
    public $returnedBy;
    public $branchId; // Branch selection
    public $godownId; // Godown selection

    public function mount($id)
    {
        $this->returnChalaanId = $id;
        $this->loadReturnChalaan();
        $this->returnedBy = Auth::id();
    }

    public function loadReturnChalaan()
    {
        $returnChalaan = ReturnChalaan::with('returnChalaanProducts')->findOrFail($this->returnChalaanId);

        // Set existing data
        $this->externalChalaanId = $returnChalaan->external_chalaan_id;
        $this->returnReferenceId = $returnChalaan->return_reference_id;
        $this->branchId = $returnChalaan->returnChalaanProducts->first()->branch_id; 
        $this->godownId = $returnChalaan->returnChalaanProducts->first()->godown_id;

        // Populate selected products
        foreach ($returnChalaan->returnChalaanProducts as $returnProduct) {
            $this->selectedProducts[$returnProduct->product_id] = [
                'isSelected' => true,
                'quantity' => $returnProduct->quantity_returned,
            ];
        }

        // Fetch associated products from the external chalaan
        $this->loadExternalChalaanProducts();
    }

    public function loadExternalChalaanProducts()
    {
        if ($this->externalChalaanId) {
            $this->products = ExternalChalaan::find($this->externalChalaanId)
                ->chalaanProducts()
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->product->id,
                        'name' => $item->product->product_name,
                        'quantity' => $item->quantity,
                    ];
                })
                ->toArray();
        }
    }

    public function updatedExternalChalaanId()
    {
        $this->selectedProducts = [];
        $this->loadExternalChalaanProducts();
    }

    public function save()
    {
        $this->validateInputs();

        DB::transaction(function () {
            $returnChalaan = ReturnChalaan::findOrFail($this->returnChalaanId);
            $returnChalaan->update([
                'external_chalaan_id' => $this->externalChalaanId,
                'returned_by' => auth()->id(),
            ]);

            foreach ($this->selectedProducts as $productId => $selected) {
                if ($selected['isSelected']) {
                    $this->updateOrCreateReturnChalaanProduct($returnChalaan->id, $productId, $selected['quantity']);
                    $this->updateStock($productId, $selected['quantity']);
                    $this->updateExternalChalaanProductQuantity($productId, $selected['quantity']);
                }
            }
        });

        $this->resetFields();
        toastr()->closeButton(true)->success('Return Chalaan updated successfully!');

        return redirect()->route('return-chalaan.index');
    }

    protected function validateInputs()
    {
        $this->validate([
            'externalChalaanId' => 'required|exists:external_chalaans,id',
            'selectedProducts' => 'required|array',
            'selectedProducts.*.isSelected' => 'required|boolean',
            'selectedProducts.*.quantity' => 'required|integer|min:1',
            'branchId' => 'required|exists:branches,id',
            'godownId' => 'required|exists:godowns,id',
        ]);
    }

    protected function updateOrCreateReturnChalaanProduct($returnChalaanId, $productId, $quantity)
    {
        ReturnChalaanProduct::updateOrCreate(
            ['return_chalaan_id' => $returnChalaanId, 'product_id' => $productId],
            ['quantity_returned' => $quantity, 'godown_id' => $this->godownId, 'branch_id' => $this->branchId]
        );
    }

    protected function updateStock($productId, $quantity)
    {
        $product = Product::with('stock')->find($productId);

        if ($product) {
            $stock = $product->stock()->where('branch_id', $this->branchId)->where('godown_id', $this->godownId)->first();

            if ($stock) {
                $stock->increment('opening_stock', $quantity);
            } else {
                Stock::create([
                    'product_id' => $productId,
                    'opening_stock' => $quantity,
                    'branch_id' => $this->branchId,
                    'godown_id' => $this->godownId,
                ]);
            }
        }
    }

    protected function updateExternalChalaanProductQuantity($productId, $quantity)
    {
        $chalaanProduct = ExternalChalaan::find($this->externalChalaanId)
            ->chalaanProducts()
            ->where('product_id', $productId)
            ->first();

        if ($chalaanProduct) {
            $newChalaanQuantity = max(0, $chalaanProduct->quantity - $quantity);
            $chalaanProduct->update(['quantity' => $newChalaanQuantity]);
        }
    }

    protected function resetFields()
    {
        $this->reset(['externalChalaanId', 'selectedProducts', 'branchId', 'godownId']);
    }

    public function render()
    {
        $externalChalaans = ExternalChalaan::all(); 
        $branches = Branch::all(); 
        $godowns = Godown::all(); 
        return view('livewire.crm.return-chalaan-edit', compact('externalChalaans', 'branches', 'godowns'));
    }
}
