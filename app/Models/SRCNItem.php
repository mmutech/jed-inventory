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
        'issued_qty'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }

    public function srcnID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'srcn_id');
    }
}
