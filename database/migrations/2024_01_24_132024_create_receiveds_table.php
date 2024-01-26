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
        Schema::create('receiveds', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('received_by');
            $table->string('received_note');
            $table->enum('received_action', ['Received', 'Rejected'])->default('Received');
            $table->date('received_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiveds');
    }
};
