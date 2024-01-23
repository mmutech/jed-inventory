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
            $table->integer('reference');
            $table->integer('station_id');
            $table->double('in')->nullable();
            $table->double('out')->nullable();
            $table->double('balance');
            $table->date('date_receipt');
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
