<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class location extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'locations';
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by'
    ];
}
