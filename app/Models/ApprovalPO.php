<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use App\Traits\CreatedUpdatedBy;

class ApprovalPO extends Model
{
    use HasFactory;
    // use CreatedUpdatedBy;

    protected $table = 'approval_p_o_s';
    protected $fillable = [
        'purchase_order_id',
        'initiator',
        'initiator_action',
        'recommended_by',
        'recommend_note',
        'recommended_action',
        'date_recommended',
        'approved_by',
        'approved_note',
        'approved_action',
        'date_approved',
    ];

    public function approvedID(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function initiatorID(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator', 'id');
    }

    public function recommendedID(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recommended_by', 'id');
    }

    public function purchasedOrderID(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }
}
