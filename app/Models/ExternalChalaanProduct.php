<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalChalaanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_chalaan_id',
        'product_id',
        'branch_id',
        'godown_id',
        'quantity',
    ];

    public function externalChalaan()
    {
        return $this->belongsTo(ExternalChalaan::class, 'external_chalaan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
