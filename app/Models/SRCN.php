<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SRCN extends Model
{
    use HasFactory;

    protected $table = 's_r_c_n_s';
    protected $fillable = [
        'srcn_id',
        'srcn_code',
        'requisitioning_store',
        'issuing_store',
        'requisition_date',
        'issue_date',
        'created_by'
    ];

    public function requisitionStationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'requisitioning_store');
    }

    public function issuingStoreID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'issuing_store');
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
