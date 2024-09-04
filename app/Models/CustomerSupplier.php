<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'mobile_no',
        'address',
        'customer_supplier',
        'gst_no',
        'country',
        'state',
        'city',
        'ip_address',
    ];
    public function users()
    {
        return $this->hasMany(CustomerSupplierUser::class);
    }
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
