<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    protected $fillable = ['product_id', 'opening_stock', 'reorder_stock', 'branch_id', 'godown_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
