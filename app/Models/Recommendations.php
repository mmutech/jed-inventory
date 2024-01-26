<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendations extends Model
{
    use HasFactory;

    protected $table = 'recommendations';
    protected $fillable = [
        'reference',
        'recommend_by',
        'recommend_note',
        'recommend_action',
        'recommend_date'
    ];

    public function recommendPOID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'reference');
    }

    public function sraRecommendID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'reference');
    }

    public function srcnRecommendID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'reference');
    }

    public function recommendID(): BelongsTo
    {
        return $this->belongsTo(user::class, 'recommend_by');
    }
}
