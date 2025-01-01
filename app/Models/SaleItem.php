<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'godown_id',
        'sub_total',
    ];

    // A sale item belongs to a sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }
    // A sale item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
