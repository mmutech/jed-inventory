<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class PurchaseOrders extends Model
{
    use HasFactory;
    // use CreatedUpdatedBy;

    protected $table = 'purchase_orders';
    protected $fillable = [
        'purchase_order_id',
        'purchase_order_no',
        'purchase_order_name',
        'vendor_name',
        'beneficiary',
        'delivery_address',
        'purchase_order_date',
        'status',
        'created_by',
        'updated_by'
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function storeID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'delivery_address');
    }
}
