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
        Schema::create('f_a_aprrovals', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('fa_approved_by');
            $table->string('fa_approved_note');
            $table->enum('fa_approved_action', ['Approved', 'Rejected'])->default('Approved');
            $table->date('fa_approved_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_aprrovals');
    }
};
