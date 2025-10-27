<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientReference extends Model
{
    protected $fillable = ['client_id', 'reference_type', 'full_name', 'relationship', 'phone', 'email', 'address', 'city', 'years_known', 'verification_status', 'verification_date', 'verification_notes', 'verified_by'];

    protected $casts = ['verification_date' => 'datetime'];

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
    public function verifiedBy(): BelongsTo { return $this->belongsTo(User::class, 'verified_by'); }
}
