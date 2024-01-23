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
        Schema::create('s_r_a_remarks', function (Blueprint $table) {
            $table->id();
            $table->integer('sra_id');
            $table->integer('purchase_order_id');
            $table->integer('raised_by');
            $table->date('raised_date');
            $table->integer('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->string('received_note')->nullable();
            $table->integer('quality_check_by')->nullable();
            $table->date('quality_check_date')->nullable();
            $table->string('quality_check_note')->nullable();
            $table->integer('account_operation_remark_by')->nullable();
            $table->date('account_operation_remark_date')->nullable();
            $table->string('account_operation_remark_note')->nullable();
            $table->enum('account_operation_action', ['Approved', 'Rejected'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_r_a_remarks');
    }
};
