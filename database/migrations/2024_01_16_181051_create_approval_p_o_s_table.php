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
        Schema::create('approval_p_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_id');
            $table->integer('initiator');
            $table->string('initiator_action');
            $table->integer('recommended_by')->nullable();
            $table->string('recommend_note')->nullable();
            $table->enum('recommended_action', ['Recommended', 'Rejected'])->nullable();
            $table->date('date_recommended')->nullable();
            $table->integer('approved_by')->nullable();
            $table->string('approved_note')->nullable();
            $table->enum('approved_action', ['Approved', 'Rejected'])->nullable();
            $table->date('date_approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_p_o_s');
    }
};
