<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityChecks extends Model
{
    use HasFactory;

    protected $table = 'quality_checks';
    protected $fillable = [
        'reference',
        'quality_check_by',
        'quality_check_note',
        'quality_check_date'
    ];

    public function sraQualityCheckID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'reference');
    }

    public function QualityCheckBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'quality_check_by');
    }
}
