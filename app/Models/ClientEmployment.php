<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ClientEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'is_current',
        'employment_type',
        'employer_name',
        'employer_nit',
        'employer_phone',
        'employer_address',
        'employer_city',
        'position',
        'start_date',
        'end_date',
        'monthly_salary',
        'other_income',
        'total_monthly_income',
        'contract_type',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_salary' => 'encrypted',
        'other_income' => 'encrypted',
        'total_monthly_income' => 'encrypted',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getMonthsEmployedAttribute(): int
    {
        $endDate = $this->is_current ? now() : $this->end_date;
        return $this->start_date->diffInMonths($endDate);
    }

    public function getIsStableAttribute(): bool
    {
        return $this->months_employed >= 6 &&
               in_array($this->employment_type, ['empleado_indefinido', 'independiente']);
    }
}
