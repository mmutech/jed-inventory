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
        Schema::create('store_bin_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_code_id');
            $table->string('reference');
            $table->integer('station_id');
            $table->integer('purchase_order_id')->nullable();
            $table->double('in')->nullable();
            $table->double('out')->nullable();
            $table->double('balance');
            $table->string('unit');
            $table->date('date_receipt')->nullable();
            $table->date('date_issue')->nullable();
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
        Schema::dropIfExists('store_bin_cards');
    }
};
