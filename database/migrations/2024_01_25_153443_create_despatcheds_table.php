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
        Schema::create('despatcheds', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('store_id');
            $table->integer('despatched_by');
            $table->string('despatched_note');
            $table->date('despatched_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despatcheds');
    }
};
