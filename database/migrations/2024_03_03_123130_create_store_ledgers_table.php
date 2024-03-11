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
        Schema::create('store_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id')->nullable();
            $table->integer('station_id');
            $table->integer('stock_code_id');
            $table->integer('unit')->nullable();
            $table->double('basic_price')->nullable();
            $table->date('date');
            $table->string('reference');
            $table->double('qty_issue')->nullable();
            $table->double('qty_receipt')->nullable();
            $table->double('qty_balance');
            $table->double('value_in')->nullable();
            $table->double('value_out')->nullable();
            $table->double('value_balance');
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
        Schema::dropIfExists('store_ledgers');
    }
};
