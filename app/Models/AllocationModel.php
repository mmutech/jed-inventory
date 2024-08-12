<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AllocationModel extends Model
{
    use HasFactory;

    protected $table = 'allocation_models';
    protected $fillable = [
        'requisition_store',
        'allocation_store',
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

    public function allocatedStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'allocation_store');
    }

    public function allocatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }
}
