<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnChalaanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_chalaan_id', 
        'product_id', 
        'quantity_returned', 
        'godown_id', 
        'branch_id',
    ];

    public function returnChalaan()
    {
        return $this->belongsTo(ReturnChalaan::class, 'return_chalaan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
