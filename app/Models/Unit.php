<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class Unit extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'units';
    protected $fillable = [
        'description',
        'created_by',
        'updated_by'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
