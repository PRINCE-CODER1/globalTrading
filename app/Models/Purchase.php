<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_no', 'supplier_id', 'purchase_date', 'ref_no', 'destination', 
        'received_through', 'gr_no', 'gr_date', 'weight', 'no_of_boxes', 
        'vehicle_no', 'branch_id', 'purchase_order_id', 'user_id',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(CustomerSupplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
