<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteTable extends Model
{
    use HasFactory;

    protected $table = 'note_tables';
    protected $fillable = [
        'reference',
        'stock_code_id',
        'issue',
        'receive',
        'recommend',
        'acctApproval',
        'allocation'
    ];

    public function stockCodeID(): BelongsTo
    {
        return $this->belongsTo(StockCode::class, 'stock_code_id');
    }
}
