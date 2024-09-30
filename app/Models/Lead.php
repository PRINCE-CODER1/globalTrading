<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_name', 
        'customer_id',
        'lead_status_id',
        'lead_source_id',
        'segment_id',
        'sub_segment_id',
        'remarks',
        'expected_date',
        'assigned_to',
        'user_id',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }

    public function subsegment()
    {
        return $this->belongsTo(Segment::class, 'sub_segment_id');
    }

    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedAgentTeam()
    {
        return $this->assignedAgent ? $this->assignedAgent->teams()->first() : null;
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
