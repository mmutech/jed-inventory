<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\CreatedUpdatedBy;

class SRARemark extends Model
{
    use HasFactory;
     // use CreatedUpdatedBy;

     protected $table = 's_r_a_remarks';
     protected $fillable = [
         'sra_id',
         'purchase_order_id',
         'raised_by',
         'raised_date',
         'raised_note',
         'received_by',
         'received_date',
         'received_note',
         'quality_check_by',
         'quality_check_date',
         'quality_check_note',
         'account_operation_remark_by',
         'account_operation_remark_date',
         'account_operation_remark_note',
         'account_operation_action'
     ];

    public function receivedID(): BelongsTo
    {
        return $this->belongsTo(SRA::class, 'sra_id', 'sra_id');
    }

    public function raisedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'raised_by', 'id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by', 'id');
    }

    public function qualityCheckBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'quality_check_by', 'id');
    }

    public function accountRemarkBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_operation_remark_by', 'id');
    }

    public function purchaseOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }
}
