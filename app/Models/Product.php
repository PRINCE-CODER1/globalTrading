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
        'child_category_id',
        // 'tax',
        'hsn_code',
        'price',
        'product_code',
        'unit_id',
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
    public function childcategory()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
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
    public function externalChalaan()
    {
        return $this->belongsTo(ExternalChalaan::class); 
    }
    public function internalChalaanProducts()
    {
        return $this->hasMany(InternalChalaanProduct::class);
    }
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    public function purchase()
    {
        return $this->hasMany(PurchaseOrderItem::class); 
    }
    public function sale()
    {
        return $this->hasMany(SaleOrderItem::class); 
    }
    public function saleOrder()
    {
        return $this->hasMany(SaleOrder::class); 
    }
}
