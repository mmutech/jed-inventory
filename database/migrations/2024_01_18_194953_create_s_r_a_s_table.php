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
        Schema::create('s_r_a_s', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->integer('sra_id');
            $table->string('sra_code');
            $table->string('consignment_note_no');
            $table->string('invoice_no');
            $table->string('delivery_note');
            $table->string('invoice_doc');
            $table->string('quality_cert');
            $table->date('received_date');
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
        Schema::dropIfExists('s_r_a_s');
    }
};
