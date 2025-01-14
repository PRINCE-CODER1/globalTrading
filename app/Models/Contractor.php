<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'address',
        'contractor_type',
        'user_id'
    ];
    public function leads()
    {
        return $this->belongsTo(Lead::class);
    }
}
