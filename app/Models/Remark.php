<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    protected $fillable = ['lead_id', 'user_id', 'remark','image'];

    public function lead()
    {
        return $this->belongsTo(Lead::class ,'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
