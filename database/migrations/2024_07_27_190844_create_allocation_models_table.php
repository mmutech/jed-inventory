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
        Schema::create('allocation_models', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('requisition_store');
            $table->integer('allocation_store');
            $table->integer('stock_code_id');
            $table->integer('quantity');
            $table->date('date')->nullable();
            $table->integer('allocated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocation_models');
    }
};
