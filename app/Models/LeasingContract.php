<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasHashedRouteKey;

class LeasingContract extends Model
{
    use HasHashedRouteKey;

    protected $fillable = [
        'contract_number',
        'client_id',
        'motorcycle_id',
        'motorcycle_value',
        'initial_payment',
        'financed_amount',
        'term_months',
        'monthly_rate',
        'monthly_payment',
        'payment_day',
        'start_date',
        'end_date',
        'status',
        'signed_contract_path',
        'contract_signed_at',
        'notes',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'contract_signed_at' => 'datetime',
        'approved_at' => 'datetime',
        'motorcycle_value' => 'decimal:2',
        'initial_payment' => 'decimal:2',
        'financed_amount' => 'decimal:2',
        'monthly_rate' => 'decimal:4',
        'monthly_payment' => 'decimal:2'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(LeasingPayment::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(MotorcycleMaintenance::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'activo' => 'bg-green-100 text-green-800',
            'completado' => 'bg-blue-100 text-blue-800',
            'mora' => 'bg-red-100 text-red-800',
            'cancelado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getPaidPaymentsCountAttribute(): int
    {
        return $this->payments()->where('status', 'pagado')->count();
    }

    public function getPendingBalanceAttribute(): float
    {
        return $this->payments()->where('status', '!=', 'pagado')->sum('amount');
    }
}
