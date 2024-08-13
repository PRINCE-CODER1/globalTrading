<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNumbering extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'financial_year',
        'sale_order_format',
        'purchase_order_format',
        'in_transit_order_format',
        'challan_format',
        'sale_format',
        'purchase_format',
        'stock_transfer_format',
        'branch_to_workshop_transfer_format',
        'workshop_to_branch_transfer_format',
        'branch_to_customer_transfer_format',
        'customer_to_branch_transfer_format',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
