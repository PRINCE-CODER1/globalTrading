<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAging extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'received_at',
        'age_days',
        'age_category'
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getAgeAttribute()
    {
        return now()->diffInDays($this->received_at);
    }
}
