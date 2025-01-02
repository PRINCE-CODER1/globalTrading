<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockCategory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * Map the row data to a Product and Stock.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Map category name to ID
        $productCategory = StockCategory::where('name', $row['product_category'] ?? '')->first();
        
        // Log the category lookup to see if it found the category
        \Log::info('Product Category Lookup', ['category' => $row['product_category'], 'found' => $productCategory]);

        // If no category found, use a default category ID or handle the error.
        $productCategoryId = $productCategory ? $productCategory->id : null;

        if (!$productCategoryId) {
            // Handle case where category is missing (e.g., create a default category or log an error)
            // For example, you can throw an exception or log the error for further investigation:
            \Log::error('Product category not found for', ['category' => $row['product_category']]);
            return null; // Skip this row or handle accordingly
        }

        // Validate required fields
        $validatedData = $this->validateRow($row, $productCategoryId);

        // Create the product (not update)
        $product = Product::updateOrCreate(
            [
                'product_category_id' => $validatedData['product_category_id'],
                'child_category_id' => $validatedData['child_category_id'],
                'series_id' => $validatedData['series_id'],
                'product_name' => $validatedData['product_name'],
                'price' => $validatedData['price'],
                'product_code' => $validatedData['product_code'],
                'unit_id' => $validatedData['unit_id'],
                'user_id' => Auth::id(),
            ]
        );

        // Create the stock entry for the product (not update)
        Stock::updateOrcreate(
            [
                'product_id' => $product->id, // Match on product_id
                'opening_stock' => $validatedData['opening_stock'],
                'reorder_stock' => $validatedData['reorder_stock'],
                'branch_id' => $validatedData['branch_id'],
                'godown_id' => $validatedData['godown_id'],
            ]
        );
    }

    /**
     * Validate and map row data.
     *
     * @param array $row
     * @param int|null $productCategoryId
     * @return array
     */
    private function validateRow(array $row, ?int $productCategoryId): array
    {
        return [
            'product_category_id' => $productCategoryId,
            'child_category_id' => $row['sub_category'] ?? null,
            'series_id' => $row['series'] ?? null,
            'product_name' => $row['product_name'] ?? null,
            'price' => $row['price'] ?? null,
            'product_code' => $row['product_code'] ?? null,
            'unit_id' => $row['units'] ?? null,
            'opening_stock' => $row['opening_stock'] ?? 0,
            'reorder_stock' => $row['reorder_stock'] ?? 0,
            'branch_id' => $row['branch'] ?? null,
            'godown_id' => $row['godown'] ?? null,
        ];
    }
}
