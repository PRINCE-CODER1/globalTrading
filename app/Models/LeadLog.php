<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo relation

class LeadLog extends Model
{
    use HasFactory;
    
    protected $table = 'lead_logs';

    // Fillable attributes
    protected $fillable = [
        'lead_id',
        'id_from',
        'id_to',
        'log_type',
        'details',
    ];

    // Define the relationship with the Lead model
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    // Define the relationship with the User model for id_from
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_from');
    }

    // Define the relationship with the User model for id_to
    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_to');
    }

    // Optionally, you can add a mutator to format the log type
    public function getLogTypeAttribute($value): string
    {
        $types = [
            'lead_created' => 'Lead Created',
            'lead_updated' => 'Lead Updated',
            'lead_reassigned' => 'Lead Reassigned',
            'lead_deleted' => 'Lead Deleted',
        ];

        return $types[$value] ?? 'Unknown';
    }
}
