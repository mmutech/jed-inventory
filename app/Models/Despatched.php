<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despatched extends Model
{
    use HasFactory;

    protected $table = 'despatcheds';
    protected $fillable = [
        'reference',
        'store_id',
        'despatched_by',
        'despatched_note',
        'despatched_date'
    ];

    public function despatchedBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'despatched_by');
    }

    public function storeID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
