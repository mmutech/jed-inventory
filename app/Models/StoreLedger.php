<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreLedger extends Model
{
    use HasFactory;

    protected $table = 'store_ledgers';
    protected $fillable = [
        'station_id',
        'stock_code_id',
        'unit',
        'basic_price',
        'date',
        'reference',
        'qty_issue',
        'qty_receipt',
        'qty_balance',
        'value_in',
        'value_out',
        'value_balance',
        'created_by',
        'updated_by'
    ];

    public function stationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'station_id');
    }
    
    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
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
