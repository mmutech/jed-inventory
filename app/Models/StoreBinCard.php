<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class StoreBinCard extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'store_bin_cards';
    protected $fillable = [
        'stock_code_id',
        'reference',
        'station_id',
        'purchase_order_id',
        'in',
        'out',
        'balance',
        'unit',
        'date_receipt',
        'date_issue',
        'created_by',
        'updated_by'
    ];

    public function storeOfficerID(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function locationID(): BelongsTo
    {
        return $this->belongsTo(location::class, 'location');
    }

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function purchaseOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }

    public function sraID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'reference');
    }

    public function stationID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'station_id');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
