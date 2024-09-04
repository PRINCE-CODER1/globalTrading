<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_no',
        'date',
        'supplier_id',
        'supplier_sale_order_no',
        'agent_id',
        'segment_id',
        'order_branch_id',
        'delivery_branch_id',
        'customer_id',
        'customer_sale_order_no',
        'customer_sale_order_date',
        'user_id',
        'subtotal',
    ];

    public function supplier()
    {
        return $this->belongsTo(CustomerSupplier::class, 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }

    public function orderBranch()
    {
        return $this->belongsTo(Branch::class, 'order_branch_id');
    }

    public function deliveryBranch()
    {
        return $this->belongsTo(Godown::class, 'delivery_branch_id');
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
