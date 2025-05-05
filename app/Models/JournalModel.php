<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalModel extends Model
{
    use HasFactory;

    protected $table = 'journal_models';
    protected $fillable = [
        'start_date',
        'end_date',
        'authorized_date',
        'prepared_date',
        'prepared_by',
        'authorized_by'
    ];

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'authorized_by');
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(user::class, 'prepared_by');
    }
}
