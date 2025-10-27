<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientContact extends Model
{
    protected $fillable = ['client_id', 'contact_type', 'address', 'neighborhood', 'city', 'department', 'country', 'postal_code', 'phone_landline', 'phone_mobile', 'email', 'is_primary', 'is_verified', 'verification_date'];

    protected $casts = ['is_primary' => 'boolean', 'is_verified' => 'boolean', 'verification_date' => 'datetime'];

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
}
