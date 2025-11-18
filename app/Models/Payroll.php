<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Payroll extends Model
{
    protected $fillable = [
        'user_id',
        'period_year',
        'period_month',
        'amount',
        'status',
        'slip_pdf_path',
        'transfer_proof_path',
        'paid_at',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
