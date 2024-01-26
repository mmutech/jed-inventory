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
        Schema::create('h_o_d_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('hod_approved_by');
            $table->string('hod_approved_note');
            $table->enum('hod_approved_action', ['Approved', 'Rejected'])->default('Approved');
            $table->date('hod_approved_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_o_d_approvals');
    }
};
