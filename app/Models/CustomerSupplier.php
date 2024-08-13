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
        'pan_no',
        'country',
        'state',
        'city',
        'ip_address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
