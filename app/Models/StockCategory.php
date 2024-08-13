<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id','user_id'];

    public function parent()
    {
        return $this->belongsTo(StockCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(StockCategory::class, 'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
