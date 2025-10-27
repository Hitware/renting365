<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasHashedRouteKey;

class Client extends Model
{
    use HasFactory, SoftDeletes, HasHashedRouteKey;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'full_name',
        'birth_date',
        'birth_place',
        'gender',
        'marital_status',
        'education_level',
        'dependents_count',
        'status',
        'assigned_analyst_id',
        'credit_score',
        'approval_date',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'approval_date' => 'datetime',
        'dependents_count' => 'integer',
        'credit_score' => 'integer',
    ];

    protected $dates = [
        'birth_date',
        'approval_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relaciones

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAnalyst(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_analyst_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }

    public function primaryContact(): HasOne
    {
        return $this->hasOne(ClientContact::class)->where('is_primary', true);
    }

    public function employments(): HasMany
    {
        return $this->hasMany(ClientEmployment::class);
    }

    public function currentEmployment(): HasOne
    {
        return $this->hasOne(ClientEmployment::class)->where('is_current', true);
    }

    public function financials(): HasMany
    {
        return $this->hasMany(ClientFinancial::class);
    }

    public function latestFinancial(): HasOne
    {
        return $this->hasOne(ClientFinancial::class)->latestOfMany();
    }

    public function references(): HasMany
    {
        return $this->hasMany(ClientReference::class);
    }

    public function credits(): HasMany
    {
        return $this->hasMany(ClientCredit::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function bankStatements(): HasMany
    {
        return $this->hasMany(ClientBankStatement::class);
    }

    public function midatacredito(): HasMany
    {
        return $this->hasMany(ClientMidatacredito::class);
    }

    public function latestMidatacredito(): HasOne
    {
        return $this->hasOne(ClientMidatacredito::class)->latestOfMany();
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ClientStatusHistory::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ClientNote::class);
    }

    public function consents(): HasMany
    {
        return $this->hasMany(ClientConsent::class);
    }

    public function leasingContracts(): HasMany
    {
        return $this->hasMany(LeasingContract::class);
    }

    // Accessors & Mutators

    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : 0;
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'registro_inicial' => 'bg-blue-100 text-blue-800',
            'documentacion_pendiente' => 'bg-yellow-100 text-yellow-800',
            'en_revision' => 'bg-purple-100 text-purple-800',
            'verificacion_referencias' => 'bg-indigo-100 text-indigo-800',
            'consulta_midatacredito' => 'bg-cyan-100 text-cyan-800',
            'analisis_financiero' => 'bg-teal-100 text-teal-800',
            'en_revision_gerencia' => 'bg-orange-100 text-orange-800',
            'aprobado' => 'bg-green-100 text-green-800',
            'rechazado' => 'bg-red-100 text-red-800',
            'congelado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'registro_inicial' => 'Registro Inicial',
            'documentacion_pendiente' => 'Documentación Pendiente',
            'en_revision' => 'En Revisión',
            'verificacion_referencias' => 'Verificación Referencias',
            'consulta_midatacredito' => 'Consulta Midatacrédito',
            'analisis_financiero' => 'Análisis Financiero',
            'en_revision_gerencia' => 'En Revisión Gerencia',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
            'congelado' => 'Congelado',
            default => ucfirst($this->status),
        };
    }

    public function getCreditScoreLevelAttribute(): string
    {
        if (!$this->credit_score) return 'sin_score';

        return match(true) {
            $this->credit_score >= 750 => 'excelente',
            $this->credit_score >= 650 => 'bueno',
            $this->credit_score >= 550 => 'regular',
            default => 'malo',
        };
    }

    // Scopes

    public function scopeApproved($query)
    {
        return $query->where('status', 'aprobado');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['registro_inicial', 'documentacion_pendiente', 'en_revision']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rechazado');
    }

    public function scopeByAnalyst($query, $analystId)
    {
        return $query->where('assigned_analyst_id', $analystId);
    }

    public function scopeByScoreRange($query, $min, $max)
    {
        return $query->whereBetween('credit_score', [$min, $max]);
    }

    // Métodos de negocio

    public function hasAllRequiredDocuments(): bool
    {
        $requiredDocs = [
            'cedula_frontal',
            'cedula_reverso',
            'certificado_laboral',
            'desprendible_pago',
            'servicio_publico'
        ];

        foreach ($requiredDocs as $docType) {
            $hasDoc = $this->documents()
                ->where('document_type', $docType)
                ->where('is_current_version', true)
                ->where('status', 'aprobado')
                ->exists();

            if (!$hasDoc) return false;
        }

        return true;
    }

    public function hasVerifiedReferences(): bool
    {
        $verifiedCount = $this->references()
            ->where('verification_status', 'verificada')
            ->count();

        return $verifiedCount >= 2;
    }

    public function canAutoApprove(): bool
    {
        return $this->credit_score >= 700 &&
               $this->hasAllRequiredDocuments() &&
               $this->hasVerifiedReferences() &&
               $this->latestMidatacredito &&
               $this->latestMidatacredito->overdue_debt == 0 &&
               $this->currentEmployment &&
               $this->latestFinancial &&
               $this->latestFinancial->debt_to_income_ratio <= 0.35;
    }

    public function updateStatus(string $newStatus, ?string $reason = null, ?string $comments = null): void
    {
        $previousStatus = $this->status;

        $this->update([
            'status' => $newStatus,
            'updated_by' => auth()->id(),
        ]);

        $this->statusHistory()->create([
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
            'change_reason' => $reason,
            'comments' => $comments,
        ]);
    }

    // Observer Events

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if (auth()->check()) {
                $client->created_by = auth()->id();
            }
        });

        static::updating(function ($client) {
            if (auth()->check()) {
                $client->updated_by = auth()->id();
            }
        });
    }
}
