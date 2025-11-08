<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeasingPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'leasing_contract_id',
        'payment_number',
        'due_date',
        'amount',
        'principal',
        'interest',
        'balance',
        'status',
        'paid_at',
        'amount_paid',
        'payment_method',
        'reference_number',
        'received_by',
        'notes',
        // Legacy fields
        'paid_amount',
        'paid_date',
        'payment_reference',
        'payment_notes',
        'processed_by'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'principal' => 'decimal:2',
        'interest' => 'decimal:2',
        'balance' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_amount' => 'decimal:2'
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(LeasingContract::class, 'leasing_contract_id');
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'pagado' => 'bg-green-100 text-green-800',
            'vencido' => 'bg-red-100 text-red-800',
            'parcial' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== 'pagado' && $this->due_date->isPast();
    }
}
