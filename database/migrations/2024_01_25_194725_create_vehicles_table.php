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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('lorry_no');
            $table->string('driver_name');
            $table->integer('pickup_station');
            $table->integer('delivery_station');
            $table->date('pickup_date');
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['Picked Up', 'Delivered'])->default('Picked Up');
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
        Schema::dropIfExists('vehicles');
    }
};
