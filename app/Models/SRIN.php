<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SRIN extends Model
{
    use HasFactory;

    protected $table = 's_r_i_n_s';
    protected $fillable = [
        'srin_id',
        'srin_code',
        'stock_code_id',
        'issuing_store',
        'location',
        'unit',
        'description',
        'required_qty',
        'issued_qty',
        'requisition_date',
        'issue_date',
        'created_by',
        'updated_by'
    ];

    public function requisitionBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'updated_by');
    }

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function locationID(): BelongsTo
    {
        return $this->belongsTo(location::class, 'location');
    }

    public function issuingStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'issuing_store');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
