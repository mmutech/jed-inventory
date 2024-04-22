<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SRCNItem extends Model
{
    use HasFactory;

    protected $table = 's_r_c_n_items';
    protected $fillable = [
        'srcn_id',
        'stock_code_id',
        'unit',
        'required_qty',
        'allocated_qty'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function srcnID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'srcn_id');
    }

    // In SRCNItem model
    public function storeBinCards()
    {
        return $this->hasMany(StoreBinCard::class, 'stock_code_id', 'stock_code_id');
    }

    public function unitID(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
