<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_category_id', 'user_id'];

    // Relationship to the parent category
    public function parentCategory()
    {
        return $this->belongsTo(StockCategory::class, 'parent_category_id');
    }

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
