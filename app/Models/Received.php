<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Received extends Model
{
    use HasFactory;

    protected $table = 'receiveds';
    protected $fillable = [
        'reference',
        'received_by',
        'received_note',
        'received_action',
        'received_date'
    ];

    public function sraReceivedID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'reference');
    }

    public function receivedID(): BelongsTo
    {
        return $this->belongsTo(user::class, 'received_by');
    }
}
