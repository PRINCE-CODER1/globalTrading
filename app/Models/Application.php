<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];
    public function leads()
    {
        return $this->belongsTo(Lead::class);
    }
}
