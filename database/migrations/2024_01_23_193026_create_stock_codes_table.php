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
        Schema::create('stock_codes', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code');
            $table->string('name');
            $table->integer('stock_category_id');
            $table->integer('stock_class_id');
            $table->integer('gl_code_id')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('stock_codes');
    }
};
