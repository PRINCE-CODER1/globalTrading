<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    protected $fillable = [
        'challan_no',
        'date',
        'user_id',
        'product_id',
        'branch_id',
        'godown_id',
        'quantity',
        'price',
    ];

    /**
     * Get the product associated with the assembly.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the branch associated with the assembly.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the godown associated with the assembly.
     */
    public function godown()
    {
        return $this->belongsTo(Godown::class);
    }

    /**
     * Get the user who created the assembly.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
