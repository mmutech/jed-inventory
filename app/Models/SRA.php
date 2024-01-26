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
        'purchase_order_id',
        'sra_id',
        'sra_code',
        'consignment_note_no',
        'invoice_no',
        'received_date',
        'created_by',
        'updated_by'
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function purchaseOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }
}
