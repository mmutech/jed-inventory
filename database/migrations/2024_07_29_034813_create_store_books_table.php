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
        Schema::create('store_books', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->integer('stock_code_id');
            $table->string('reference');
            $table->integer('station_id');
            $table->integer('issue_store')->nullable();
            $table->double('qty_in')->nullable();
            $table->double('qty_out')->nullable();
            $table->double('qty_balance');
            $table->double('basic_price');
            $table->double('value_in')->nullable();
            $table->double('value_out')->nullable();
            $table->double('value_balance');
            $table->date('date');
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
        Schema::dropIfExists('store_books');
    }
};
