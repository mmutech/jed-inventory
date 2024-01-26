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
        Schema::create('s_r_c_n_s', function (Blueprint $table) {
            $table->id();
            $table->integer('srcn_id');
            $table->string('srcn_code');
            $table->integer('requisitioning_store');
            $table->integer('issuing_store')->nullable();
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
        Schema::dropIfExists('s_r_c_n_s');
    }
};
