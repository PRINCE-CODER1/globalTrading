<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalChalaanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_chalaan_id',
        'from_godown_id',
        'to_godown_id',
        'product_id',
        'quantity',
    ];

    public function internalChalaan()
    {
        return $this->belongsTo(InternalChalaan::class);
    }

    public function fromGodown()
    {
        return $this->belongsTo(Godown::class, 'from_godown_id');
    }

    public function toGodown()
    {
        return $this->belongsTo(Godown::class, 'to_godown_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class); 
    }
}
