<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference_id', 
        'customer_name', 
        'customer_id',
        'lead_status_id',
        'lead_source_id',
        'segment_id',
        'sub_segment_id',
        'category_id',
        'child_category_id',
        'lead_type_id',
        'contractors',
        'amount',
        'specification',
        'series',
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
    public function category()
    {
        return $this->belongsTo(StockCategory::class);
    }
    public function series()
    {
        return $this->belongsTo(Series::class, 'series');
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

    public function assignedAgentTeams()
    {
        // Retrieve teams assigned to the agent
        return $this->assignedAgent ? $this->assignedAgent->teams : collect(); // Return an empty collection if no agent is assigned
    }

    public function managerTeams()
    {
        // Fetch the teams associated with the creator (manager) of the lead
        return $this->creator->teams(); // Use () to call the relationship method
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define relationship to creator (manager) of the lead
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
