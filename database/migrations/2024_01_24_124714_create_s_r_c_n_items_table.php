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
        Schema::create('s_r_c_n_items', function (Blueprint $table) {
            $table->id();
            $table->integer('srcn_id');
            $table->integer('stock_code_id');
            $table->integer('unit');
            $table->integer('required_qty');
            $table->integer('allocated_qty')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_r_c_n_items');
    }
};
