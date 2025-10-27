<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMidatacredito extends Model
{
    use HasFactory;

    protected $table = 'client_midatacredito';

    protected $fillable = [
        'client_id',
        'query_date',
        'query_type',
        'score',
        'risk_level',
        'active_credits_count',
        'total_debt',
        'overdue_debt',
        'worst_status',
        'credit_cards_count',
        'last_query_date',
        'inquiries_last_6_months',
        'has_legal_proceedings',
        'response_json',
        'queried_by',
    ];

    protected $casts = [
        'query_date' => 'datetime',
        'last_query_date' => 'date',
        'has_legal_proceedings' => 'boolean',
        'response_json' => 'array',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function queriedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'queried_by');
    }
}
