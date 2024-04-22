<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allocation extends Model
{
    use HasFactory;
    protected $table = 'allocations';
    protected $fillable = [
        'station_id',
        'quantity',
        'reference',
        'stock_code_id',
        'date',
        'allocated_by'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function srcnID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'reference', 'srcn_code');
    }

    public function stationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'station_id');
    }
}
