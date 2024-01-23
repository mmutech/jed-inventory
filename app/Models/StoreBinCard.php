<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class StoreBinCard extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'store_bin_cards';
    protected $fillable = [
        'stock_code_id',
        'reference',
        'station_id',
        'in',
        'out',
        'balance',
        'date_receipt',
        'date_issue',
        'created_by',
        'updated_by'
    ];

    public function storeOfficerID(): BelongsTo
    {
        return $this->belongsTo(User::class, 'store_officer');
    }

    public function locationID(): BelongsTo
    {
        return $this->belongsTo(location::class, 'location');
    }
}
