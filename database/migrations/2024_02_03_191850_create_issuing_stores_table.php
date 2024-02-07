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
        Schema::create('issuing_stores', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('station_id');
            $table->integer('stock_code_id');
            $table->integer('quantity');
            $table->date('date')->nullable();
            $table->integer('issued_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuing_stores');
    }
};
