<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssuingStore extends Model
{
    use HasFactory;
    protected $table = 'issuing_stores';
    protected $fillable = [
        'from_station',
        'to_station',
        'quantity',
        'reference',
        'stock_code_id',
        'purchase_order_id',
        'date',
        'issued_by'
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

    public function purchaseOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }
}
