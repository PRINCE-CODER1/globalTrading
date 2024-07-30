<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'mobile', 'address',
    ];
    
    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
