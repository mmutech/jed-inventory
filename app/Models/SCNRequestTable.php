<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SCNRequestTable extends Model
{
    use HasFactory;

    protected $table = 's_c_n_request_tables';
    protected $fillable = [
        'reference',
        'stock_code_id',
        'quantity_returned',
        'srin_id',
        'return_date',
        'added_by',
        'updated_by'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function SrinId(): BelongsTo
    {
        return $this->belongsTo(RequestItemTable::class, 'srin_id');
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
