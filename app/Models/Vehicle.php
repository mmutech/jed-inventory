<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Livewire\store;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        'reference',
        'lorry_no',
        'driver_name',
        'delivery_station',
        'pickup_station',
        'pickup_date',
        'delivery_date',
        'status',
        'created_by',
        'updated_by'
    ];

    public function deliveryStation(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'delivery_station');
    }

    public function pickUpStation(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'pickup_station');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
