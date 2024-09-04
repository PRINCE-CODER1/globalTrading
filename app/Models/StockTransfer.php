<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'stock_transfer_no',
        'from_branch_id',
        'stock_transfer_date',
        'ref_no',
        'destination',
        'dispatch_through',
        'gr_no',
        'gr_date',
        'weight',
        'no_of_boxes',
        'vehicle_no',
        'to_branch_id',
        'to_godown_id',
        'user_id',
    ];

    /**
     * Get the branch the stock is transferred from.
     */
    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    /**
     * Get the branch the stock is transferred to.
     */
    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    /**
     * Get the godown the stock is transferred to.
     */
    public function toGodown()
    {
        return $this->belongsTo(Godown::class, 'to_godown_id');
    }

    /**
     * Get the user who performed the stock transfer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
