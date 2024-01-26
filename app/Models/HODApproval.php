<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HODApproval extends Model
{
    use HasFactory;
    protected $table = 'h_o_d_approvals';
    protected $fillable = [
        'reference',
        'hod_approved_by',
        'hod_approved_note',
        'hod_approved_action',
        'hod_approved_date'
    ];

    public function hodApproved(): BelongsTo
    {
        return $this->belongsTo(user::class, 'hod_approved_by');
    }
}
