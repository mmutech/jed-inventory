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
        Schema::create('s_c_n_request_tables', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('srin_id');
            $table->integer('stock_code_id');
            $table->integer('quantity_returned');
            $table->date('return_date');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_c_n_request_tables');
    }
};
