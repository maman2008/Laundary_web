<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class EmployeeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'start_date',
        'end_date',
        'attachment_path',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
