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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_id');
            $table->string('description');
            $table->integer('unit');
            $table->integer('quantity');
            $table->double('rate');
            $table->integer('balance_qty')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('confirm_qty')->nullable();
            $table->integer('confirm_bal_qty')->nullable();
            $table->double('confirm_rate')->nullable();
            $table->integer('confirm_by')->nullable();
            $table->integer('confirm_bal_by')->nullable();
            $table->integer('quality_check')->nullable();
            $table->integer('balance_check')->nullable();
            $table->integer('recommend')->nullable();
            $table->string('stock_code')->nullable();
            $table->date('confirm_date')->nullable();
            $table->date('confirm_bal_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
