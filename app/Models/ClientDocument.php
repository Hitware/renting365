<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientDocument extends Model
{
    use SoftDeletes;

    protected $fillable = ['client_id', 'document_type', 'file_name', 'file_path', 'file_size', 'mime_type', 'version', 'upload_date', 'expiry_date', 'status', 'reviewed_by', 'review_date', 'review_comments', 'is_current_version', 'uploaded_by'];

    protected $casts = ['upload_date' => 'datetime', 'review_date' => 'datetime', 'expiry_date' => 'date', 'is_current_version' => 'boolean'];

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
    public function uploadedBy(): BelongsTo { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function reviewedBy(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by'); }
}
