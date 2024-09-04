<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    // Relationship to child categories
    public function childCategories()
    {
        return $this->hasMany(ChildCategory::class, 'parent_category_id');
    }

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
