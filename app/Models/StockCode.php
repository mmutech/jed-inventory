<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class StockCode extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;


    protected $table = 'stock_codes';
    protected $fillable = [
        'stock_code',
        'name',
        'stock_category_id',
        'stock_class_id',
        'gl_code_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function stockCategoryID(): BelongsTo
    {
        return $this->belongsTo(StockCategory::class, 'stock_category_id');
    }
    
    public function stockClassID(): BelongsTo
    {
        return $this->belongsTo(StockClass::class, 'stock_class_id');
    }

}
