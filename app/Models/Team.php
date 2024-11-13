<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'creator_id'];
    
    public function agents()
    {
        return $this->belongsToMany(User::class, 'user_team', 'team_id', 'user_id');
    }

    // Define the relationship to the user who created the team
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
