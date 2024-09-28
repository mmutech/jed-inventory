<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class Item extends Model
{
    use HasFactory;
    // use CreatedUpdatedBy;

    protected $table = 'items';
    protected $fillable = [
        'purchase_order_id',
        'description',
        'unit',
        'quantity',
        'rate',
        'balance_qty',
        'updated_by',
        'confirm_qty',
        'confirm_bal_qty',
        'confirm_rate',
        'confirm_by',
        'confirm_date',
        'confirm_bal_by',
        'confirm_bal_date',
        'quality_check',
        'balance_check',
        'recommend',
        'stock_code'
    ];

    public function purchaseOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
