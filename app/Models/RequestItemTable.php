<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestItemTable extends Model
{
    use HasFactory;

    protected $table = 'request_item_tables';
    protected $fillable = [
        'reference',
        'stock_code_id',
        'work_location',
        'job_description',
        'quantity_required',
        'quantity_issued',
        'requisition_store',
        'requisition_date',
        'issue_date',
        'status',
        'added_by',
        'updated_by'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function requisitionStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'requisition_store');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
