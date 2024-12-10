<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductStockExport implements FromCollection, WithHeadings
{
    protected $products;

    // Pass the filtered products to the constructor
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'product_name' => $product->product_name,
                'opening_stock' => $product->stock->opening_stock ?? 'N/A',
                'purchase_count' => $product->purchase_count ?? 0,
                'sale_count' => $product->sale_count ?? 0,
                'closing_stock' => ($product->stock->opening_stock ?? 0)
                    + $product->purchase_count
                    - $product->sale_count,
                'reorder_stock' => $product->stock->reorder_stock ?? 'N/A',
                'price' => $product->price ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Opening Stock',
            'Purchase Count',
            'Sales Count',
            'Closing Stock',
            'Re-Order Stock',
            'Product Price',
        ];
    }
}
