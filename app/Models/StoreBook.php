<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreBook extends Model
{
    use HasFactory;
    protected $table = 'store_books';
    protected $fillable = [
        'purchase_order_id',
        'station_id',
        'issue_store',
        'stock_code_id',
        'basic_price',
        'date',
        'reference',
        'qty_in',
        'qty_out',
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

    public function issueStationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'issue_store');
    }
    
    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function jobOrderId(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
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
