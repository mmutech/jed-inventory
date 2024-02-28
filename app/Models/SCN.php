<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SCN extends Model
{
    use HasFactory;

    protected $table = 's_c_n_s';
    protected $fillable = [
        'scn_id',
        'scn_code',
        'job_from',
        'stock_code_id',
        'unit',
        'quantity',
        'station_id',
        'returned_date',
        'received_by',
        'created_by',
        'updated_by'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function jobFrom(): BelongsTo
    {
        return $this->belongsTo(location::class, 'job_from');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
    }

    public function stationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'station_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
