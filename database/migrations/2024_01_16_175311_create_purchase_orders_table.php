<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->string('purchase_order_no');
            $table->string('purchase_order_name');
            $table->string('vendor_name');
            $table->string('beneficiary');
            $table->string('delivery_address');
            $table->date('purchase_order_date');
            $table->enum('status', ['Approved', 'Completed', 'Pending', 'Incomplete'])->default('Pending');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
