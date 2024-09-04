<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock_category_id',
        'child_category_id',
        'user_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function stockCategory()
    {
        return $this->belongsTo(StockCategory::class, 'stock_category_id');
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
