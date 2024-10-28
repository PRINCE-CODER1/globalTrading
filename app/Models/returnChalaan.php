<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnChalaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_chalaan_id', 
        'return_reference_id', 
        'returned_by'
    ];

    public function externalChalaan()
    {
        return $this->belongsTo(ExternalChalaan::class, 'external_chalaan_id');
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    // Relationship to Return Chalaan Products
    public function returnChalaanProducts()
    {
        return $this->hasMany(ReturnChalaanProduct::class, 'return_chalaan_id');
    }
}
