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
        Schema::create('s_c_n_s', function (Blueprint $table) {
            $table->id();
            $table->integer('scn_id');
            $table->string('scn_code');
            $table->string('job_from');
            $table->integer('stock_code_id');
            $table->integer('unit');
            $table->integer('quantity');
            $table->integer('station_id')->nullable();
            $table->date('returned_date')->nullable();
            $table->integer('received_by')->nullable();
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
        Schema::dropIfExists('s_c_n_s');
    }
};
