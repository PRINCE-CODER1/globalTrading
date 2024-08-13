<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'series_id',
        'product_description',
        'product_category_id',
        'tax',
        'product_model',
        'hsn_code',
        'price',
        'product_code',
        'opening_stock',
        'reorder_stock',
        'branch_id',
        'godown_id',
        'unit_id',
        'image',
        'user_id',
        'modified_by',
        'received_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function category()
    {
        return $this->belongsTo(StockCategory::class, 'product_category_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'unit_id');
    }
    protected $dates = ['received_at'];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
