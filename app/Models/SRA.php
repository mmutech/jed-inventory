<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class SRA extends Model
{
    use HasFactory;
    // use CreatedUpdatedBy;

    protected $table = 's_r_a_s';
    protected $fillable = [
        'sra_code',
        'consignment_note_no',
        'invoice_no',
        'updated_by'
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
