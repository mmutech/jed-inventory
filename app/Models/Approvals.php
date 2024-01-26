<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approvals extends Model
{
    use HasFactory;
    protected $table = 'approvals';
    protected $fillable = [
        'reference',
        'approved_by',
        'approved_note',
        'approved_action',
        'approved_date'
    ];

    public function approvedPOID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'reference');
    }

    public function sraApprovalID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'reference');
    }

    public function srcnApprovalID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'reference');
    }

    public function approvedID(): BelongsTo
    {
        return $this->belongsTo(user::class, 'approved_by');
    }
}
