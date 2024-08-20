<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssembleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'assembly_id',
        'product_id',
        'branch_id',
        'godown_id',
        'quantity',
        'price',
    ];

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Define the relationship with the Godown model
    public function godown()
    {
        return $this->belongsTo(Godown::class);
    } 
}
