<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class StockClass extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'stock_classes';
    protected $fillable = [
        'name',
        'stock_category_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function stockCategoryID(): BelongsTo
    {
        return $this->belongsTo(StockCategory::class, 'stock_category_id');
    }
}
