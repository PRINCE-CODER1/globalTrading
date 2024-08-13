<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'visit_date',
        'location',
        'purpose',
        'notes',
    ];
    // Alternatively, you can use $casts for explicit casting
    protected $casts = [
        'visit_date' => 'datetime',
    ];
    protected $dates = ['visit_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
