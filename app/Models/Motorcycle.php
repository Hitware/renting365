<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasHashedRouteKey;

class Motorcycle extends Model
{
    use HasFactory, HasHashedRouteKey;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'displacement',
        'plate',
        'motor_number',
        'chassis_number',
        'color',
        'status',
        'current_owner_id',
        'purchase_price',
        'purchase_date',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'purchase_date' => 'date'
    ];

    public function leasingContracts(): HasMany
    {
        return $this->hasMany(LeasingContract::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(MotorcycleMaintenance::class);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'in_maintenance' => 'bg-yellow-100 text-yellow-800',
            'damaged' => 'bg-red-100 text-red-800',
            'sold' => 'bg-blue-100 text-blue-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
