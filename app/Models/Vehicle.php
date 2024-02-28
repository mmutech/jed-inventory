<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        'reference',
        'lorry_no',
        'driver_name',
        'location',
        'store_id',
        'vehicle_date',
        'created_by',
        'updated_by'
    ];

    public function srcnID(): BelongsTo
    {
        return $this->belongsTo(SRCN::class, 'reference');
    }

    public function locationID(): BelongsTo
    {
        return $this->belongsTo(location::class, 'location');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function storeID(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
