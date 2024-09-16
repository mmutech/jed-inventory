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
        Schema::create('request_item_tables', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('stock_code_id');
            $table->integer('quantity_required');
            $table->string('work_location')->nullable();
            $table->string('job_description')->nullable();
            $table->integer('quantity_issued')->nullable();
            $table->integer('requisition_store')->nullable();
            $table->date('requisition_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->enum('status', ['Pending', 'Recommended', 'Approved', 'Allocated', 'Issued', 'Received'])->default('Pending');
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
        Schema::dropIfExists('request_item_tables');
    }
};
