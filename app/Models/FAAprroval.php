<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FAAprroval extends Model
{
    use HasFactory;

    protected $table = 'f_a_aprrovals';
    protected $fillable = [
        'reference',
        'fa_approved_by',
        'fa_approved_note',
        'fa_approved_action',
        'fa_approved_date'
    ];

    public function faApproved(): BelongsTo
    {
        return $this->belongsTo(user::class, 'fa_approved_by');
    }
}
