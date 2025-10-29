<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditApplication extends Model
{
    protected $fillable = [
        'full_name',
        'document_number',
        'phone',
        'email',
        'city',
        'motorcycle_type',
        'approximate_value',
        'status',
        'assigned_advisor_id',
        'observations',
    ];

    protected $casts = [
        'approximate_value' => 'decimal:2',
    ];

    public function assignedAdvisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_advisor_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'in_study' => 'En Estudio',
            'approved' => 'Aprobado',
            'rejected' => 'Rechazado',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'gray',
            'in_study' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
        };
    }
}
