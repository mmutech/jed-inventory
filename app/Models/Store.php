<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class Store extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;


    protected $table = 'stores';
    protected $fillable = [
        'store_id',
        'name',
        'store_officer',
        'location',
        'status',
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
