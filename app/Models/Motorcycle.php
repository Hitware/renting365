<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasHashedRouteKey;

class Motorcycle extends Model
{
    use HasHashedRouteKey;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate',
        'vin',
        'color',
        'engine_capacity',
        'purchase_price',
        'current_value',
        'status',
        'mileage',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'engine_capacity' => 'integer',
        'mileage' => 'integer',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2'
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
