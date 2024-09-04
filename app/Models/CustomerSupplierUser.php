<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupplierUser extends Model
{
    use HasFactory;
    protected $fillable = ['customer_supplier_id', 'name', 'email', 'phone', 'designation'];

    public function customerSupplier()
    {
        return $this->belongsTo(CustomerSupplier::class);
    }
}
