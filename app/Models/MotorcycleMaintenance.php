<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MotorcycleMaintenance extends Model
{
    protected $fillable = [
        'motorcycle_id',
        'leasing_contract_id',
        'type',
        'title',
        'description',
        'scheduled_date',
        'completed_date',
        'status',
        'workshop_name',
        'technician_name',
        'estimated_cost',
        'actual_cost',
        'mileage_km',
        'next_maintenance_date',
        'next_maintenance_km',
        'notes',
        'registered_by'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'next_maintenance_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2'
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(LeasingContract::class, 'leasing_contract_id');
    }

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
