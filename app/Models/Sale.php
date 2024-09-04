<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_no',
        'customer_id',
        'sale_date',
        'branch_id',
        'sale_order_id',
        'godown_id',
        'ref_no',
        'destination',
        'dispatch_through',
        'gr_no',
        'gr_date',
        'weight',
        'no_of_boxes',
        'vehicle_no',
        'user_id',
    ];

    // A sale belongs to a customer
    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }

    // A sale belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // A sale belongs to a sale order
    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_id');
    }

    // A sale belongs to a godown
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }

    // A sale belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A sale has many items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
