<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'active','parent_id'];

    public function parent()
    {
        return $this->belongsTo(Segment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Segment::class, 'parent_id');
    }
}
