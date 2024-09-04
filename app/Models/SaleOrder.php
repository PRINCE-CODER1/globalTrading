<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sale_order_no',
        'date',
        'customer_id',
        'agent_id',
        'segment_id',
        'lead_source_id',
        'order_branch_id',
        'delivery_branch_id',
        'user_id',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class);
    }
    public function products()
    {
        return $this->hasMany(SaleOrderItem::class);
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function orderBranch()
    {
        return $this->belongsTo(Branch::class, 'order_branch_id');
    }

    public function deliveryBranch()
    {
        return $this->belongsTo(Godown::class, 'delivery_branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function items()
    {
        return $this->hasMany(SaleOrderItem::class, 'sale_order_id');
    }
}
