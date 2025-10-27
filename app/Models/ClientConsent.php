<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'consent_type',
        'consent_text',
        'accepted',
        'acceptance_date',
        'acceptance_ip',
        'acceptance_user_agent',
        'revoked',
        'revocation_date',
    ];

    protected $casts = [
        'accepted' => 'boolean',
        'revoked' => 'boolean',
        'acceptance_date' => 'datetime',
        'revocation_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
