<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalChalaan extends Model
{
    use HasFactory;

    protected $fillable = ['reference_id', 'chalaan_type_id', 'customer_id', 'created_by','branch_id','godown_id'];

    public function chalaanType()
    {
        return $this->belongsTo(ChallanType::class);
    }

    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }

    public function chalaanProducts()
    {
        return $this->hasMany(ExternalChalaanProduct::class, 'external_chalaan_id');
    }
    public function product()
    {
        return $this->hasMany(ExternalChalaanProduct::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
