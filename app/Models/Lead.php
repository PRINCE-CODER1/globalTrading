<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'reference_id', 
        'customer_name', 
        'customer_id',
        'customer_supplier_user_id',
        'lead_status_id',
        'lead_source_id',
        'segment_id',
        'sub_segment_id',
        'category_id',
        'child_category_id',
        'lead_type_id',
        'application_id',
        'contractor_ids',
        'amount',
        'specification',
        'series',
        'remarks',
        'expected_date',
        'assigned_to',
        'user_id', 
    ];
    protected $casts = [
        'contractor_ids' => 'array', 
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(CustomerSupplier::class, 'customer_id');
    }
    public function customerUser()
    {
        return $this->belongsTo(CustomerSupplierUser::class, 'customer_supplier_user_id');
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
    public function ChildCategory()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
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

    public function leadType()
    {
        return $this->belongsTo(LeadType::class, 'lead_type_id');
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
    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }
}
