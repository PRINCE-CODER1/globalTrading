<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dar extends Model
{
    use HasFactory;
    protected $table = 'dar';
    protected $primaryKey = 'dar_id';
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $fillable = [
        'customer_id',
        'pov_id',
        'date',
        'remarks',
        'status',
        'user_id',
        'rating'
    ];
    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }

    // A DarForm belongs to a purpose of visit (POV)
    public function purposeOfVisit()
    {
        return $this->belongsTo(VisitMaster::class, 'pov_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
