<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalChalaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'chalaan_type_id',
        'created_by',
        'from_branch_id',
        'to_branch_id',
        'from_godown_id',
        'to_godown_id',
    ];

    public function products()
    {
        return $this->hasMany(InternalChalaanProduct::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function fromGodown()
    {
        return $this->belongsTo(Godown::class, 'from_godown_id');
    }

    public function toGodown()
    {
        return $this->belongsTo(Godown::class, 'to_godown_id');
    }
}
