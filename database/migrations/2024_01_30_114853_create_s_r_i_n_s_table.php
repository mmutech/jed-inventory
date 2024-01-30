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
        Schema::create('s_r_i_n_s', function (Blueprint $table) {
            $table->id();
            $table->integer('srin_id');
            $table->string('srin_code');
            $table->integer('station_id');
            $table->integer('stock_code_id');
            $table->string('description');
            $table->string('unit');
            $table->integer('required_qty');
            $table->integer('issued_qty')->nullable();
            $table->date('requisition_date');
            $table->date('issue_date')->nullable();
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
        Schema::dropIfExists('s_r_i_n_s');
    }
};
