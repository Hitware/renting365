<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MotorcycleMaintenance extends Model
{
    protected $fillable = [
        'leasing_contract_id',
        'motorcycle_id',
        'maintenance_type',
        'scheduled_date',
        'completed_date',
        'current_mileage',
        'status',
        'description',
        'work_performed',
        'cost',
        'invoice_number',
        'performed_by'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'cost' => 'decimal:2'
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(LeasingContract::class, 'leasing_contract_id');
    }

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'programado' => 'bg-blue-100 text-blue-800',
            'completado' => 'bg-green-100 text-green-800',
            'cancelado' => 'bg-gray-100 text-gray-800',
            'vencido' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
