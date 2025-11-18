<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'check_in_at',
        'check_out_at',
        'photo_path',
        'lat',
        'lng',
        'is_late',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
