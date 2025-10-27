<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'client_status_history';

    protected $fillable = [
        'client_id',
        'previous_status',
        'new_status',
        'changed_by',
        'change_reason',
        'comments',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
